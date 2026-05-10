<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->string('statut')->default('valide')->after('dateRetour'); // valide, en_attente, rendu
        });
    }

    public function down(): void
    {
        Schema::table('emprunts', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};
