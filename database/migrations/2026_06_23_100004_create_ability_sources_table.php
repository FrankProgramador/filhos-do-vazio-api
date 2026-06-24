<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ability_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ability_id')->constrained()->cascadeOnDelete();
            $table->morphs('source');
            $table->unsignedSmallInteger('level')->nullable();
            $table->timestamps();

            $table->unique(['ability_id', 'source_type', 'source_id', 'level'], 'ability_sources_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ability_sources');
    }
};
