<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->boolean('pinned')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'quote_id']); // prevent duplicate saves
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quotes');
    }
};

