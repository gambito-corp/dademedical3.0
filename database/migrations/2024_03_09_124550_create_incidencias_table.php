<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('responding_user_id')->nullable()->constrained('users');
            $table->string('tipo_incidencia'); // (avería, mantenimiento, etc.)
            $table->string('incidencia');
            $table->string('respuesta')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('fecha_incidencia');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
