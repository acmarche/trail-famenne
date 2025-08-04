<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;
use App\Invoice\Invoice;
use App\Mail\InvoicePaid;
use App\Mail\RegistrationCompleted;
use App\Models\Walker;
use App\Utils\RegistrationUtils;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

class SendRegistrationNotification
{
    /**
     * Generate pdf
     * Generate Qrcode
     * Send mail with pdf
     */
    public function handle(RegistrationProcessed $event): void
    {
        $walker = $event->walker();
        $walker->registration_id = RegistrationUtils::lastRegistrationId() + 1;
        $walker->save();

        try {
            Invoice::generateWithQrCode($walker);
        } catch (BindingResolutionException|\Exception $e) {
            dd($e->getMessage());
        }

        if (!$walker->email) {
            return;
        }

        if ($walker->isPaid()) {
            $this->sendPaid($walker);
        } else {
            $this->sendNotPaid($walker);
        }
    }

    private function sendPaid(Walker $walker): void
    {
        try {
            Mail::to(new Address($walker->email, $walker->email))
                ->send(new InvoicePaid($walker));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function sendNotPaid(Walker $walker): void
    {
        try {
            Mail::to(new Address($walker->email, $walker->email))
                ->send(new RegistrationCompleted($walker));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
