<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('original_user_id')->nullable()->constrained('users');
            $table->string('ip_address');
            $table->string('url');
            $table->string('function');
            $table->string('accion');
            $table->string('method');
            $table->string('message');
            $table->string('level');
            $table->json('context')->nullable();
            $table->string('comentario');
            $table->json('strackTrace')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
