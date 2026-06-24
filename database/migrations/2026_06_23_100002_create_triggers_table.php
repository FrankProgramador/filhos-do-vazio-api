<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('triggers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('condition_type', ['none', 'target_health_less_than', 'target_has_status', 'caster_has_effect', 'custom']);
            $table->json('condition_value')->nullable();
            $table->enum('target_type', ['self', 'target', 'allies', 'enemies', 'area']);
            $table->enum('area_shape', ['self', 'cone', 'explosion', 'line', 'cube'])->nullable();
            $table->json('area_params')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('triggers');
    }
};
