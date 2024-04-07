<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('contrato_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->foreignId('producto_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contrato_productos');
    }
};
