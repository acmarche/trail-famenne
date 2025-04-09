<?php

namespace App\Mail;

use App\Filament\FrontPanel\Resources\WalkerResource;
use App\Models\Walker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaid extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $logo = null;
    public ?string $qrcode = null;

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
            subject: __('invoices::messages.email.invoice.paid.subject'),
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

        return new Content(
            markdown: 'emails.invoice',
            with: [
                'textbtn' => __('invoices::messages.email.registration.confirm.btn.label'),
                'url' => WalkerResource::getUrl('complete', ['record' => $this->walker], panel: 'front'),
                'logo' => $this->logo,
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

        return $attachments;
    }

}
