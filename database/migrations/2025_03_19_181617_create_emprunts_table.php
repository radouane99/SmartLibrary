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
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            // $table->string('codeA');
            // $table->string('codeL');
            // $table->foreign('codeA')->references('codeA')->on('adherents')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('codeL')->references('codeL')->on('livres')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("user_id")->constrained("users","id")->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("livre_id")->constrained("livres","id")->onUpdate('cascade')->onDelete('cascade');
            $table->date('dateEmp');
            $table->date('dateRetour');
            $table->unique(['user_id', 'livre_id','dateEmp']);

            // $table->primary(['codeA','codeL']);
                        
            // $table->primary(['adherent_id','livre_id']);

            $table->timestamps() ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};
