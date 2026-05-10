<?php

namespace App\Mail;

use App\Models\Emprunt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNouvelleReservation extends Mailable
{
    use Queueable, SerializesModels;

    public $emprunt;

    public function __construct(Emprunt $emprunt)
    {
        $this->emprunt = $emprunt;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Nouvelle demande de réservation - ' . $this->emprunt->livre->titre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_nouvelle_reservation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
