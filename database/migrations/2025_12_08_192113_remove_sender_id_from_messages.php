<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, migrate data from old columns to new columns if they exist
        if (Schema::hasColumn('messages', 'user_id') && Schema::hasColumn('messages', 'sender_id')) {
            DB::statement('UPDATE messages SET sender_id = user_id WHERE sender_id IS NULL OR sender_id = 0');
        }
        if (Schema::hasColumn('messages', 'consultant_id') && Schema::hasColumn('messages', 'receiver_id')) {
            DB::statement('UPDATE messages SET receiver_id = consultant_id WHERE receiver_id IS NULL OR receiver_id = 0');
        }
        
        // For SQLite, we need to drop foreign keys first by recreating the table
        if (DB::getDriverName() === 'sqlite') {
            // Check if old columns exist before trying to drop them
            if (Schema::hasColumn('messages', 'user_id') || Schema::hasColumn('messages', 'consultant_id')) {
                // SQLite doesn't support dropping columns with foreign keys directly
                // We'll recreate the table without those columns
                DB::statement('PRAGMA foreign_keys=off;');
                
                // Create new table structure
                DB::statement('
                    CREATE TABLE messages_new (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        sender_id INTEGER NOT NULL,
                        receiver_id INTEGER,
                        content TEXT NOT NULL,
                        created_at DATETIME,
                        updated_at DATETIME
                    )
                ');
                
                // Copy data (use sender_id/receiver_id if they exist and have data, otherwise use old columns)
                if (Schema::hasColumn('messages', 'sender_id') && Schema::hasColumn('messages', 'receiver_id')) {
                    DB::statement('
                        INSERT INTO messages_new (id, sender_id, receiver_id, content, created_at, updated_at)
                        SELECT id, 
                               COALESCE(sender_id, user_id) as sender_id,
                               COALESCE(receiver_id, consultant_id) as receiver_id,
                               content, created_at, updated_at
                        FROM messages
                    ');
                } else {
                    DB::statement('
                        INSERT INTO messages_new (id, sender_id, receiver_id, content, created_at, updated_at)
                        SELECT id, user_id, consultant_id, content, created_at, updated_at
                        FROM messages
                    ');
                }
                
                // Drop old table and rename new one
                DB::statement('DROP TABLE messages;');
                DB::statement('ALTER TABLE messages_new RENAME TO messages;');
                
                DB::statement('PRAGMA foreign_keys=on;');
            }
        } else {
            // For other databases, drop foreign keys first, then columns
            Schema::table('messages', function (Blueprint $table) {
                if (Schema::hasColumn('messages', 'user_id')) {
                    $table->dropForeign(['user_id']);
                }
                if (Schema::hasColumn('messages', 'consultant_id')) {
                    $table->dropForeign(['consultant_id']);
                }
            });
            
            Schema::table('messages', function (Blueprint $table) {
                if (Schema::hasColumn('messages', 'user_id')) {
                    $table->dropColumn('user_id');
                }
                if (Schema::hasColumn('messages', 'consultant_id')) {
                    $table->dropColumn('consultant_id');
                }
                
                // Only add if they don't already exist (they were added in previous migration)
                if (!Schema::hasColumn('messages', 'sender_id')) {
                    $table->unsignedBigInteger('sender_id')->after('id');
                }
                if (!Schema::hasColumn('messages', 'receiver_id')) {
                    $table->unsignedBigInteger('receiver_id')->after('sender_id');
                }
            });
        }
    }
    
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'sender_id')) {
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('messages', 'receiver_id')) {
                $table->dropColumn('receiver_id');
            }
            
            if (!Schema::hasColumn('messages', 'user_id')) {
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('messages', 'consultant_id')) {
                $table->unsignedBigInteger('consultant_id');
                $table->foreign('consultant_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
};
