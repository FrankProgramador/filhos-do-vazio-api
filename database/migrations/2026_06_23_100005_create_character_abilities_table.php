<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('character_abilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ability_id')->constrained()->cascadeOnDelete();
            $table->morphs('source');
            $table->integer('quantity')->default(1);
            $table->integer('uses_remaining')->nullable();
            $table->timestamps();

            $table->unique(['character_id', 'ability_id', 'source_type', 'source_id'], 'character_abilities_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_abilities');
    }
};
