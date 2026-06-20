<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->unique(['equipment_package_id', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_package_items');
    }
};
