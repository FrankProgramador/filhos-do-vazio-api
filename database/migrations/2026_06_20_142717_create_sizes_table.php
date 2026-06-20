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

            $table->decimal('poder', 4, 1);
            $table->decimal('saber', 4, 1);
            $table->decimal('casca', 4, 1);
            $table->decimal('graca', 4, 1);
            $table->decimal('coracao', 4, 1);
            $table->decimal('estamina', 4, 1);
            $table->decimal('alma', 4, 1);
            $table->decimal('velocidade', 4, 1);
            $table->decimal('fofo', 4, 1);
            $table->decimal('assustador', 4, 1);

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
