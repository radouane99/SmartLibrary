<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Correction : dateRetour ne doit pas être obligatoire à la création d'un emprunt.
 * Une demande "en_attente" n'a pas encore de date de retour fixée par l'admin.
 * On rend ce champ nullable pour respecter le cycle de vie réel de l'emprunt.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->date('dateRetour')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->date('dateRetour')->nullable(false)->change();
        });
    }
};
