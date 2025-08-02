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
        Schema::create('agenda_medica', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
        $table->string('dia_semana');
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->time('almuerzo_inicio');
        $table->time('almuerzo_fin');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_medica');
    }
};
