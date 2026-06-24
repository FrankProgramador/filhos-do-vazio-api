<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arena_matches', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('waiting'); // waiting | active | finished
            $table->unsignedInteger('turn_number')->default(1);
            $table->unsignedBigInteger('current_token_id')->nullable();
            $table->unsignedBigInteger('winner_token_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arena_matches');
    }
};
