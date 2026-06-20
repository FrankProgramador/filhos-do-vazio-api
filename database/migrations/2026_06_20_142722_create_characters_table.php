<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('species')->nullable();
            $table->string('avatar')->nullable();

            $table->foreignId('size_id')->constrained()->restrictOnDelete();
            $table->foreignId('trilha_id')->nullable()->constrained('trilhas')->nullOnDelete();

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

            $table->integer('sustento');
            $table->integer('sustento_maximo');
            $table->integer('geo')->default(50);
            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);

            $table->text('story')->nullable();
            $table->text('appearance')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
