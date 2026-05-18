<?php

namespace Database\Seeders;

// use App\Models\Adherent; // removed – not needed
use App\Models\Livre;
use App\Models\Theme;
use App\Models\User;
use App\Models\Emprunt;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Adherent::factory()->create([
        //     'codeA' => 'a1',
        //     'nomA' => 'khaldi',
        //     'adresseA' => 'avenue med6',
        //     'dateInscrip' => '2025-03-20',
        //     'email' => 'khaldi@gmail.com',
        //     'password'=> Hash::make('1234') 
        // ]);
        User::factory()->create([
            'codeA' => 'A1234',
            'name' => 'Radouane',
            'email' => 'radouane.asri99@gmail.com',
            'adresse' => 'Avenue med 5',
            'role' => 'admin',
            'photo' => 'Inkonnu',
            'password' => Hash::make('radouane123')
        ]);
        User::factory()->create([
            'codeA' => 'B1234',
            'name' => 'rabie',
            'email' => 'radouane.elasri@usmba.ac.ma',
            'adresse' => 'Avenue med 6',
            'role' => 'adherent',
            'photo' => 'Inkonnu',
            'password' => Hash::make('radouane123')
        ]);
        // Création des Thèmes
        $themeLitterature = Theme::create([
            'codeTh' => 'TH01',
            'intitule' => 'Littérature Marocaine'
        ]);

        $themeInfo = Theme::create([
            'codeTh' => 'TH02',
            'intitule' => 'Informatique & Technologies'
        ]);

        $themeScience = Theme::create([
            'codeTh' => 'TH03',
            'intitule' => 'Sciences'
        ]);

        $themeArt = Theme::create([
            'codeTh' => 'TH04',
            'intitule' => 'Arts & Culture'
        ]);

        // Création des Livres — Couvertures stockées dans storage/app/public/photos/
        // Placer les images dans : storage/app/public/photos/
        Livre::create([
            'codeL' => 'L001',
            'titre' => 'La Boîte à Merveilles',
            'auteur' => 'Ahmed Sefrioui',
            'nbExemplaire' => 10,
            'theme_id' => $themeLitterature->id,
            'couverture' => 'photos/boite_merveilles.jpg'
        ]);

        Livre::create([
            'codeL' => 'L002',
            'titre' => 'Le Pain Nu',
            'auteur' => 'Mohamed Choukri',
            'nbExemplaire' => 5,
            'theme_id' => $themeLitterature->id,
            'couverture' => 'photos/pain_nu.jpg'
        ]);

        Livre::create([
            'codeL' => 'L003',
            'titre' => "L'Enfant de Sable",
            'auteur' => 'Tahar Ben Jelloun',
            'nbExemplaire' => 7,
            'theme_id' => $themeLitterature->id,
            'couverture' => 'photos/enfant_sable.jpg'
        ]);

        Livre::create([
            'codeL' => 'L004',
            'titre' => 'Maîtriser Laravel 11',
            'auteur' => 'Taylor Otwell',
            'nbExemplaire' => 12,
            'theme_id' => $themeInfo->id,
            'couverture' => 'photos/laravel.jpg'
        ]);

        Livre::create([
            'codeL' => 'L005',
            'titre' => 'Intelligence Artificielle',
            'auteur' => 'Yann LeCun',
            'nbExemplaire' => 8,
            'theme_id' => $themeInfo->id,
            'couverture' => 'photos/ia.jpg'
        ]);

        Livre::create([
            'codeL' => 'L006',
            'titre' => "L'Univers Élégant",
            'auteur' => 'Brian Greene',
            'nbExemplaire' => 4,
            'theme_id' => $themeScience->id,
            'couverture' => 'photos/univers_elegant.jpg'
        ]);

        Livre::create([
            'codeL' => 'L007',
            'titre' => "Histoire de l'Art au Maroc",
            'auteur' => 'Farid Belkahia',
            'nbExemplaire' => 3,
            'theme_id' => $themeArt->id,
            'couverture' => 'photos/art_maroc.jpg'
        ]);

        // Theme::factory(4)->create();

        // -------------------------------------------------
        // Additional Admins & Adherents (Scenarios)
        // -------------------------------------------------
        // Two more admins for multi‑admin testing
        User::factory()->create([
            'codeA'    => 'A002',
            'name'     => 'Admin Deux',
            'email'    => 'admin2@demo.com',
            'adresse'  => 'Avenue admin 2',
            'role'     => 'admin',
            'photo'    => 'admin2.jpg',
            'password' => Hash::make('admin123'),
        ]);
        User::factory()->create([
            'codeA'    => 'A003',
            'name'     => 'Admin Trois',
            'email'    => 'admin3@demo.com',
            'adresse'  => 'Avenue admin 3',
            'role'     => 'admin',
            'photo'    => 'admin3.jpg',
            'password' => Hash::make('admin123'),
        ]);

        // -------------------------------------------------
        // Moroccan Adherent Users (role = 'adherent')
        // -------------------------------------------------
        $marocAdherents = [
            ['codeA' => 'B001', 'name' => 'Youssef Amrani', 'email' => 'youssef.amrani@example.com', 'adresse' => 'Rue Al Qods, Rabat'],
            ['codeA' => 'B002', 'name' => 'Fatima Zahra', 'email' => 'fatima.zahra@example.com', 'adresse' => 'Avenue des Fleurs, Casablanca'],
            ['codeA' => 'B003', 'name' => 'Ahmed El Youssfi', 'email' => 'ahmed.youssfi@example.com', 'adresse' => 'Lotissement Al Madar, Marrakech'],
            ['codeA' => 'B004', 'name' => 'Khadija Benali', 'email' => 'khadija.benali@example.com', 'adresse' => 'Résidence Al Amal, Fès'],
            ['codeA' => 'B005', 'name' => 'Rachid Slaoui', 'email' => 'rachid.slaoui@example.com', 'adresse' => 'Villa Ouarzazate, Ouarzazate'],
        ];
        $adherentUsers = [];
        foreach ($marocAdherents as $adh) {
            $adherentUsers[] = User::factory()->create([
                'codeA'    => $adh['codeA'],
                'name'     => $adh['name'],
                'email'    => $adh['email'],
                'adresse'  => $adh['adresse'],
                'role'     => 'adherent',
                'photo'    => 'adherent.jpg',
                'password' => Hash::make('adherent123'),
            ]);
        }

        // -------------------------------------------------
        // Sample Emprunts: pending reservations (dateRetour = null)
        // -------------------------------------------------
        foreach ($adherentUsers as $user) {
            $livre = Livre::inRandomOrder()->first();
            Emprunt::create([
                'user_id'    => $user->id,
                'livre_id'   => $livre->id,
                'dateEmp'    => now()->subDays(rand(1, 10)),
                // réservation en attente : dateRetour null
                'dateRetour' => null,
            ]);
        }

        // -------------------------------------------------
        // Admin validates a couple of those reservations (sets dateRetour)
        // -------------------------------------------------
        $admin = User::where('role', 'admin')->first();
        $pending = Emprunt::whereNull('dateRetour')->take(2)->get();
        foreach ($pending as $empreint) {
            $empreint->update([
                'dateRetour' => now(), // admin validates now
            ]);
        }

        // -------------------------------------------------
        // Additional random emprunts for demonstration (mixed status)
        // -------------------------------------------------
        foreach ($adherentUsers as $user) {
            $livre = Livre::inRandomOrder()->first();
            Emprunt::create([
                'user_id'    => $user->id,
                'livre_id'   => $livre->id,
                'dateEmp'    => now()->subDays(rand(1, 30)),
                'dateRetour' => rand(0,1) ? now()->subDays(rand(0,5)) : null,
            ]);
        }
    }
}
