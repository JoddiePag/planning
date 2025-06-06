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
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // Clé étrangère vers la table 'patients'
            $table->foreignId('dentiste_id')->constrained('dentistes')->onDelete('cascade');

            // $table->foreignId('patient_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table patients
            // $table->foreignId('dentiste_id')->constrained('dentiste')->onDelete('cascade'); // Clé étrangère vers la table users (si les dentistes sont des utilisateurs)
            $table->string('type_ordonnance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
    }
};
