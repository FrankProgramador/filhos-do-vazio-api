<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arena_match_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arena_match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('character_id')->nullable()->constrained()->nullOnDelete();

            $table->string('label');
            $table->string('color');
            $table->unsignedInteger('col');
            $table->unsignedInteger('row');
            $table->unsignedInteger('movement');
            $table->unsignedInteger('movement_used')->default(0);
            $table->unsignedInteger('hp');
            $table->unsignedInteger('max_hp');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arena_match_tokens');
    }
};
