<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('messages', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('messages', 'consultant_id')) {
                $table->dropColumn('consultant_id');
            }

            // Add new columns
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->unsignedBigInteger('sender_id')->after('id');
            }
            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->unsignedBigInteger('receiver_id')->nullable()->after('sender_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'sender_id')) {
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('messages', 'receiver_id')) {
                $table->dropColumn('receiver_id');
            }

            if (!Schema::hasColumn('messages', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
            if (!Schema::hasColumn('messages', 'consultant_id')) {
                $table->unsignedBigInteger('consultant_id')->nullable();
            }
        });
    }
};

