<?php

namespace App\Mail;

use App\Models\Emprunt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RappelRetour extends Mailable
{
    use Queueable, SerializesModels;

    public $emprunt;

    public function __construct(Emprunt $emprunt)
    {
        $this->emprunt = $emprunt;
    }

    public function build()
    {
        return $this->subject('📚 Rappel : Retour de livre dans 2 jours')
                    ->view('emails.rappel_retour');
    }
}
