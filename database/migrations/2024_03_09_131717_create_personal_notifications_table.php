<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('personal_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sender_id')->constrained('users');
            $table->string('tipo_notificacion');
            $table->string('notificacion');
            $table->string('mensaje');
            $table->string('url');
            $table->boolean('active')->default(false);
            $table->timestamp('fecha_notificacion');
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_notifications');
    }
};
