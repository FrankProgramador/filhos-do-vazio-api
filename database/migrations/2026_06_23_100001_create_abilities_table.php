<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['active', 'passive', 'reaction']);
            $table->enum('scope', ['passive', 'per_turn', 'per_scene', 'per_session'])->default('passive');
            $table->json('activation_cost')->nullable();
            $table->integer('cooldown')->default(0);
            $table->boolean('is_magic')->default(false);
            $table->boolean('is_unique')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abilities');
    }
};
