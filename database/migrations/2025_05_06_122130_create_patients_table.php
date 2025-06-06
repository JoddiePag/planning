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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->integer('age');
            $table->string('motif')->nullable();
            $table->string('antecedents_medicaux')->nullable();
            $table->string('traitements')->nullable();
            $table->date('prochain_rdv')->nullable();
            $table->time('heure_rdv');
            $table->string('ordonnance')->nullable();
            $table->integer('total_soins');
            $table->unsignedBigInteger('dentiste_id')->nullable(); 
            $table->foreign('dentiste_id')->references('id')->on('dentistes')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
        
    }
};
