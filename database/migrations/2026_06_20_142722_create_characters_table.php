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
            $table->unsignedTinyInteger('trilha_level')->default(1);

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
