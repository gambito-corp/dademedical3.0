<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('hospitals');
            $table->string('nombre');
            $table->string('acronimo');
            $table->string('direccion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
