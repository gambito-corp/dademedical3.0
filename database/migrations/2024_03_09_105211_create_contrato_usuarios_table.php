<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained();
            $table->foreignId('solicitante_id')->constrained('users'); // refiere al id de la tabla 'users'
            $table->foreignId('aprobador_id')->nullable()->constrained('users');  // refiere al id de la tabla 'users' y puede ser NULL
            $table->foreignId('bajador_id')->nullable()->constrained('users'); // refiere al id de la tabla 'users' y puede ser NULL
            $table->foreignId('finalizador_id')->nullable()->constrained('users'); // refiere al id de la tabla 'users' y puede ser NULL
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
        Schema::dropIfExists('contrato_usuarios');
    }
}
