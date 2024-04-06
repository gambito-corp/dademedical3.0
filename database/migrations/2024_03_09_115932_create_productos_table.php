<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('contrato_id')->nullable()->constrained();
            $table->boolean('activo')->default(true);
            $table->date('fecha_mantenimiento')->default(now());
            $table->string('productable_type');
            $table->unsignedBigInteger('productable_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
