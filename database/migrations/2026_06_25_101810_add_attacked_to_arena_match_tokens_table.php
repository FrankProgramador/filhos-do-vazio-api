<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arena_match_tokens', function (Blueprint $table) {
            $table->boolean('attacked')->default(false)->after('movement_used');
        });
    }

    public function down(): void
    {
        Schema::table('arena_match_tokens', function (Blueprint $table) {
            $table->dropColumn('attacked');
        });
    }
};
