<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->string('dossier')->nullable();
            $table->string('situation_familiale')->nullable();
            $table->string('num_personne_charge')->nullable();
            $table->string('ville')->nullable();
            $table->text('adresse')->nullable();
            $table->string('periodicite')->nullable();
            $table->string('salaire_jrs')->nullable();
            $table->string('conge_mois')->nullable();
            $table->string('anciente')->nullable();
            $table->text('motif_depart')->nullable();
            $table->string('duree_contrat')->nullable();
            $table->date('fin_contrat')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('Augmentation')->nullable();
            $table->date('Agt_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
