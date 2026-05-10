<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationRetour extends Mailable
{
    use Queueable, SerializesModels;
    public $emprunt;

    public function __construct($emprunt)
    {
        $this->emprunt = $emprunt;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de retour d\'ouvrage - SmartLibrary',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.confirmation_retour',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
