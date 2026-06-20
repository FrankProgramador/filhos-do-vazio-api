<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('weight', 6, 2)->default(0);
            $table->string('quality')->nullable();
            $table->integer('base_price')->default(10);
            $table->integer('durability')->nullable();
            $table->boolean('is_consumable')->default(false);
            $table->enum('type', ['weapon', 'armor', 'shield', 'tool', 'consumable', 'accessory', 'other']);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
