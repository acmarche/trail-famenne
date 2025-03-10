<?php

namespace App\Listeners;

use App\Events\RegistrationProcessed;
use App\Invoice\Invoice;
use App\Mail\InvoicePaid;
use App\Mail\RegistrationCompleted;
use App\Models\Registration;
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
        $registration = $event->registration();

        try {
            Invoice::generateWithQrCode($registration);
        } catch (BindingResolutionException|\Exception $e) {
            dd($e->getMessage());
        }

        if ($registration->isPaid()) {
            $this->sendPaid($registration);
        } else {
            $this->sendNotPaid($registration);
        }
    }

    private function sendPaid(Registration $registration): void
    {
        try {
            Mail::to(new Address($registration->email, $registration->email))
                ->send(new InvoicePaid($registration));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function sendNotPaid(Registration $registration): void
    {
        try {
            Mail::to(new Address($registration->email, $registration->email))
                ->send(new RegistrationCompleted($registration));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
