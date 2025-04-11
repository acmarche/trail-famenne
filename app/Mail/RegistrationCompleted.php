<?php

namespace App\Mail;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Invoice\Facades\Invoice;
use App\Invoice\Facades\QrCodeGenerator;
use App\Models\Walker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RegistrationCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $logo = null;
    public ?string $qrcode = null;
    public ?string $bankAccount = null;
    public ?string $registrationEndDate = null;

    public function __construct(public readonly Walker $walker)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('APP_NAME')),
            subject: __('invoices::messages.email.registration.confirm.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->logo = public_path('images/logoMarcheur.jpg');
        if (!file_exists($this->logo)) {
            $this->logo = null;
        }

        $this->qrcode = QrCodeGenerator::make()
            ->id($this->walker->id)
            ->qrCodePath();

        $this->bankAccount = config('seller.bank_account');
        $this->registrationEndDate = Carbon::parse(config('invoices.TRAIL_TSHIRT_ENDDATE'))->translatedFormat('j F Y');

        return new Content(
            view: 'emails.registration',
            with: [
                'textbtn' => __('invoices::messages.email.registration.confirm.btn.label'),
                'url' => WalkerResource::getUrl('complete', ['record' => $this->walker], panel: 'front'),
                'logo' => $this->logo,
                'qrCode' => $this->qrcode,
                'bankAccount' => $this->bankAccount,
                'registrationEndDate' => $this->registrationEndDate,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        $attachments[] =
            Attachment::fromPath($this->logo)
                ->as('logoMarcheur.jpg')
                ->withMime('image/jpg');

        $invoicePath = Invoice::make()
            ->walker($this->walker)
            ->invoicePath();

        $invoiceFileName = Invoice::make()
            ->walker($this->walker)
            ->invoiceFileName();

        if (is_file($invoicePath)) {
            $attachments[] =
                Attachment::fromStorageDisk('invoices', $invoiceFileName)
                    ->as($invoiceFileName)
                    ->withMime('application/pdf');
        }

        return $attachments;
    }

}
