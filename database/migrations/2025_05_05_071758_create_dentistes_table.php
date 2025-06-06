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
        Schema::create('dentistes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            // $table->string('email')->unique();
            $table->string('email');
            $table->string('numero');
            $table->string('adresse')->nullable();
            $table->string('motdepasse');
            $table->string('motdepasse_confirmation');
            $table->string('qualifications')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dentistes');
        
    }
};
