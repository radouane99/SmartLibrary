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
        Theme::factory()->has(Livre::factory(4))->count(4)->create();

        // Theme::factory(4)->create();
    }
}
