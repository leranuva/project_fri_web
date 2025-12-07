<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class QuoteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $quoteData;

    private $pdfBase64;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $message, string $pdfBase64, array $quoteData)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->quoteData = $quoteData;
        $this->pdfBase64 = $pdfBase64;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote',
            with: [
                'message' => $this->message,
                'quoteData' => $this->quoteData,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(
                base64_decode($this->pdfBase64),
                'cotizacion_' . ($this->quoteData['productName'] ?? 'producto') . '_' . date('Y-m-d') . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
