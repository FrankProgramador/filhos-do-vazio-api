<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->integer('poder');
            $table->integer('saber');
            $table->integer('casca');
            $table->integer('graca');
            $table->integer('coracao');
            $table->integer('estamina');
            $table->integer('alma');
            $table->integer('velocidade');
            $table->integer('fofo');
            $table->integer('assustador');

            $table->integer('sustento_inicial');
            $table->integer('sustento_maximo');

            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
