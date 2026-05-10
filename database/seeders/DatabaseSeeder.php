<?php

namespace Database\Seeders;

use App\Models\Adherent;
use App\Models\Livre;
use App\Models\Theme;
use App\Models\User;
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
            'name' => 'Khaldi',
            'email' => 'khaldi@gmail.com',
            'adresse' => 'Avenue med 5',
            'role' => 'admin',
            'photo'=>'Inkonnu',
            'password'=> Hash::make('khaldi')
        ]);
        User::factory()->create([
            'codeA' => 'B1234',
            'name' => 'Ahmed',
            'email' => 'ahmed@gmail.com',
            'adresse' => 'Avenue med 6',
            'role' => 'adherent',
            'photo'=>'Inkonnu',
            'password'=> Hash::make('ahmed')
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

        // Création des Livres Marocains et autres
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
            'titre' => 'L\'Enfant de Sable',
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
            'titre' => 'L\'Univers Élégant',
            'auteur' => 'Brian Greene',
            'nbExemplaire' => 4,
            'theme_id' => $themeScience->id,
            'couverture' => 'photos/univers.jpg'
        ]);

        Livre::create([
            'codeL' => 'L007',
            'titre' => 'Histoire de l\'Art au Maroc',
            'auteur' => 'Farid Belkahia',
            'nbExemplaire' => 3,
            'theme_id' => $themeArt->id,
            'couverture' => 'photos/art_maroc.jpg'
        ]);

        // Theme::factory(4)->create();
    }
}
