<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ability_triggers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ability_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trigger_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['ability_id', 'trigger_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ability_triggers');
    }
};
