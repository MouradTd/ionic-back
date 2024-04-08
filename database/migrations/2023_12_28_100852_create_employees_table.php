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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('phone_no')->nullable();
            $table->string('matricule')->unique();
            $table->string('email')->unique();
            $table->string('type')->default('employee');
            $table->date('birthdate')->nullable();
            $table->string('sexe')->nullabe();
            $table->string('cin')->nullable();
            $table->string('copie_cin')->nullable();
            $table->string('cnss')->nullable();
            $table->string('copie_cnss')->nullable();
            $table->string('rib')->nullable();
            $table->string('copie_rib')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('flotte')->nullable();
            $table->date('date_embauche')->nullable();
            $table->date('date_depart')->nullable();
            $table->string('departement')->nullable();
            $table->string('poste')->nullable();
            $table->string('societe')->nullable();
            $table->string('type_contrat')->nullable();
            $table->string('salary')->nullable();
            $table->string('salary_net')->nullable();
            $table->string('salary_brut')->nullable();
            $table->string('virement')->nullable();
            $table->date('date_virement')->nullable();
            $table->string('ir')->nullable();
            $table->string('tfp')->nullable();
            $table->double('solde_conge')->nullable();
            $table->string('copie_appt')->nullable();
            $table->string('copie_atts_travail')->nullable();
            $table->string('copie_cdn_compte')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
