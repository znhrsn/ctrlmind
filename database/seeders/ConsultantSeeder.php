<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConsultantSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name' => 'Maria Cruz',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'role' => 'consultant',
        ]);

        User::create([
            'name' => 'Jose Lee',
            'email' => 'jose@example.com',
            'password' => Hash::make('password123'),
            'role' => 'consultant',
        ]);
    }
}
