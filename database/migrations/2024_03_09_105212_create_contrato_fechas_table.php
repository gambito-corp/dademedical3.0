<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_fechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->datetime('fecha_solicitud');
            $table->datetime('fecha_aprobacion')->nullable();
            $table->datetime('fecha_rechazo')->nullable();
            $table->datetime('fecha_anulacion')->nullable();
            $table->datetime('fecha_entrega')->nullable();
            $table->datetime('fecha_baja')->nullable();
            $table->datetime('fecha_recogida')->nullable();
            $table->datetime('fecha_finalizado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_fechas');
    }
}
