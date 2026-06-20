<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traits', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->enum('category', ['body', 'senses', 'movement', 'defense', 'social', 'mystic', 'personality']);
            $table->enum('rarity', ['common', 'remarkable', 'rare', 'personality']);
            $table->text('description');
            $table->text('mechanical_effect')->nullable();
            $table->text('roleplay_obligation')->nullable();
            $table->integer('sustento_cost')->default(0);
            $table->integer('max_selections')->default(1);
            $table->boolean('is_inherent')->default(false);
            $table->foreignId('prerequisite_trait_id')->nullable()->constrained('traits')->nullOnDelete();
            $table->string('thumb')->nullable();
            $table->timestamps();

            $table->index(['category', 'rarity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traits');
    }
};
