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
        Schema::create('lecon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prof_id')->constrained('employee')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classe')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->string('titre');
            $table->text('description');
            $table->string('attachement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecon');
    }
};
