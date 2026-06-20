<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('character_traits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trait_id')->constrained('traits')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->boolean('is_inherent')->default(false);
            $table->boolean('is_personality')->default(false);
            $table->boolean('is_extra')->default(false);
            $table->timestamps();

            $table->unique(['character_id', 'trait_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_traits');
    }
};
