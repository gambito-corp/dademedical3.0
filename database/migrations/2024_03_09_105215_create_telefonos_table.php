<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->string('numero');
            $table->string('tipo'); // móvil, casa, trabajo, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telefonos');
    }
};
