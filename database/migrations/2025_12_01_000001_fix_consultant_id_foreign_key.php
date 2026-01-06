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
    public function up(): void
    {
        // For SQLite, foreign keys are embedded in the table structure
        // We need to recreate the table without the invalid foreign key
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');
            
            // Recreate users table without the invalid foreign key
            // We'll keep consultant_id but without the constraint for now
            DB::statement('
                CREATE TABLE users_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    email_verified_at DATETIME NULL,
                    password VARCHAR(255) NOT NULL,
                    remember_token VARCHAR(100) NULL,
                    consultant_id BIGINT UNSIGNED NULL,
                    role VARCHAR(255) NULL DEFAULT "user",
                    gender VARCHAR(255) NULL,
                    consultant_pref VARCHAR(255) NULL,
                    created_at DATETIME NULL,
                    updated_at DATETIME NULL
                )
            ');
            
            // Copy data
            DB::statement('
                INSERT INTO users_new (id, name, email, email_verified_at, password, remember_token, consultant_id, role, gender, consultant_pref, created_at, updated_at)
                SELECT id, name, email, email_verified_at, password, remember_token, consultant_id, role, gender, consultant_pref, created_at, updated_at
                FROM users
            ');
            
            // Drop old table and rename
            DB::statement('DROP TABLE users;');
            DB::statement('ALTER TABLE users_new RENAME TO users;');
            
            DB::statement('PRAGMA foreign_keys=on;');
        } else {
            Schema::table('users', function (Blueprint $table) {
                // Drop the old foreign key if it exists
                try {
                    $table->dropForeign(['consultant_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist or have different name
                }
            });
            
            Schema::table('users', function (Blueprint $table) {
                // Add new foreign key pointing to users table (self-referential)
                $table->foreign('consultant_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['consultant_id']);
            });
        }
    }
};

