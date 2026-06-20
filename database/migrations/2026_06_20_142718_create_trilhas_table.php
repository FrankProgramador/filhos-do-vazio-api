<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trilhas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nome');
            $table->enum('tipo', ['marcial', 'mistico']);
            $table->string('thumb')->nullable();
            $table->integer('nivel')->nullable();
            $table->text('beneficios');
            $table->enum('barra_aumentada', ['estamina', 'alma']);
            $table->integer('aumento')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trilhas');
    }
};
