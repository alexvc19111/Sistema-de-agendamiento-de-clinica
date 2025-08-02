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
        Schema::create('atencions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turno_id')->constrained('turnos')->onDelete('cascade');
            $table->string('presion')->nullable();
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable(); // Ej: 75
            $table->integer('frecuencia_respiratoria')->nullable(); // Ej: 18
            $table->decimal('peso', 5, 2)->nullable(); // Ej: 65.5
            $table->decimal('talla', 5, 2)->nullable(); // Ej: 1.75
            $table->text('diagnostico')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencions');
    }
};
