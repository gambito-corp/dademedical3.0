<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->string('historia_clinica')->nullable();
            $table->string('diagnostico');
            $table->double('dosis');
            $table->integer('frecuencia');
            $table->string('comentarios')->nullable();
            $table->boolean('active');
            $table->datetime('fecha_cambio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};
