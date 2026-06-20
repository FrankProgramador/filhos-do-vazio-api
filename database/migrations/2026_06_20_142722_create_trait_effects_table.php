<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trait_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trait_id')->constrained('traits')->cascadeOnDelete();
            $table->foreignId('effect_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['trait_id', 'effect_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trait_effects');
    }
};
