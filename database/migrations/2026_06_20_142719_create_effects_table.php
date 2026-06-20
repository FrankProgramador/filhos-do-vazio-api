<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('effects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['buff', 'debuff', 'damage', 'heal', 'utility']);
            $table->enum('duration_type', ['instant', 'turns', 'scene', 'permanent']);
            $table->integer('duration_value')->nullable();
            $table->json('tags')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('effects');
    }
};
