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
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // Clé étrangère vers la table 'patients'
            // $table->foreignId('soin_id')->constrained('soins')->onDelete('cascade'); // Clé étrangère vers la table 'soins'
            $table->dateTime('date_heure_rdv')->nullable(); 
            $table->Time('heure_fin')->nullable(); 
            // $table->integer('duree')->nullable(); 
        

            $table->string('statut', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
