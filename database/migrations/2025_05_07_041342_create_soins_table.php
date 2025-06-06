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
        Schema::create('soins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
    $table->string('dent');
    $table->string('traitement');
     $table->string('type_dent');
    $table->integer('prix');
    $table->integer('recu'); 
        $table->integer('reste');
    //     $table->string('overlay_type')->nullable();
       $table->text('overlay_position')->nullable();
    // $table->string('type_dent');
        
    // $table->foreignId('rendez_vous_id')->nullable()->constrained('rendez_vouses');
  
    // $table->unsignedBigInteger('rendez_vous_id')->nullable()->change();
    // $table->foreign('rendez_vous_id')
    //       ->references('id')->on('rendez_vous')
    //       ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soins');
    }
};
