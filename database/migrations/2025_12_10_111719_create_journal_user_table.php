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
        if (!Schema::hasTable('journal_user')) {
            Schema::create('journal_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('journal_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('consultant_id');
                $table->timestamps();

                $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('consultant_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_user');
    }
};
