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
        Schema::create('seance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prof_id')->constrained('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date');
            $table->time('heur_debut');
            $table->time('heur_fin');
            $table->string('nom');
            $table->foreignId('classe_id')->constrained('classe')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seance');
    }
};
