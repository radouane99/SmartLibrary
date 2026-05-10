<?php

namespace App\Console\Commands;

use App\Mail\RappelRetour;
use App\Models\Emprunt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelsRetour extends Command
{
    protected $signature = 'rappels:envoyer';
    protected $description = 'Envoyer des rappels par email aux adhérents dont le retour est dans 2 jours';

    public function handle()
    {
        $dateJ2 = now()->addDays(2)->toDateString();

        $emprunts = Emprunt::with(['livre', 'user'])
            ->where('statut', 'valide')
            ->where('dateRetour', $dateJ2)
            ->get();

        $count = 0;

        foreach ($emprunts as $emprunt) {
            try {
                if ($emprunt->user && $emprunt->user->email) {
                    Mail::to($emprunt->user->email)->send(new RappelRetour($emprunt));
                    $count++;
                    $this->info("✅ Rappel envoyé à {$emprunt->user->name} ({$emprunt->user->email})");
                }
            } catch (\Exception $e) {
                $this->error("❌ Erreur pour {$emprunt->user->name}: {$e->getMessage()}");
            }
        }

        $this->info("📧 Total: {$count} rappel(s) envoyé(s) sur {$emprunts->count()} emprunt(s) à J-2.");

        return Command::SUCCESS;
    }
}
