<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->unsignedTinyInteger('energy')->nullable()->after('mood');
            $table->unsignedTinyInteger('focus')->nullable()->after('energy');
            $table->unsignedTinyInteger('satisfaction')->nullable()->after('focus');
            $table->unsignedTinyInteger('self_kindness')->nullable()->after('satisfaction');
            $table->unsignedTinyInteger('relaxation')->nullable()->after('self_kindness');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->dropColumn(['energy', 'focus', 'satisfaction', 'self_kindness', 'relaxation']);
        });
    }
};

