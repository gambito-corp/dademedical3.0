<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // Elimina las columnas que ya no se necesitan
            $table->dropColumn('accion');
            $table->dropColumn('level');
            $table->dropColumn('context');
            $table->dropColumn('comentario');
            $table->dropColumn('strackTrace');

            // Agrega aquí nuevas columnas si es necesario
        });
    }

    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            // Para revertir los cambios, deberías agregar de nuevo las columnas eliminadas
            // y especificar sus tipos. Esto es solo un ejemplo y necesitarás ajustarlo.
            $table->string('accion')->nullable();
            $table->string('level')->nullable();
            $table->json('context')->nullable();
            $table->string('comentario')->nullable();
            $table->json('strackTrace')->nullable();

            // Si agregaste nuevas columnas en el método up(), deberías eliminarlas aquí
        });
    }
};
