<?php

namespace App\Mail;

use App\Models\Emprunt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LateBookNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emprunt;

    /**
     * Create a new message instance.
     */
    public function __construct(Emprunt $emprunt)
    {
        $this->emprunt = $emprunt;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Avertissement : Livre en retard - SmartLibrary',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.late_book',
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
