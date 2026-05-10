<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelManuel extends Mailable
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
            subject: 'Rappel : Retour de l\'ouvrage - SmartLibrary',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rappel_manuel',
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
