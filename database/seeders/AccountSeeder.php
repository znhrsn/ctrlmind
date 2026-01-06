<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get consultants to assign to some users
        $consultants = User::where('role', 'consultant')->get();
        $consultantIds = $consultants->pluck('id')->toArray();

        // Create regular user accounts
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'male',
                'consultant_pref' => 'male',
                'consultant_id' => !empty($consultantIds) ? $consultantIds[0] : null,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'female',
                'consultant_pref' => 'female',
                'consultant_id' => !empty($consultantIds) ? ($consultantIds[1] ?? $consultantIds[0]) : null,
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.johnson@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'male',
                'consultant_pref' => null,
                'consultant_id' => !empty($consultantIds) ? $consultantIds[0] : null,
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'female',
                'consultant_pref' => 'female',
                'consultant_id' => !empty($consultantIds) ? ($consultantIds[1] ?? $consultantIds[0]) : null,
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'male',
                'consultant_pref' => 'male',
                'consultant_id' => !empty($consultantIds) ? $consultantIds[0] : null,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'female',
                'consultant_pref' => null,
                'consultant_id' => !empty($consultantIds) ? ($consultantIds[1] ?? $consultantIds[0]) : null,
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'male',
                'consultant_pref' => 'male',
                'consultant_id' => !empty($consultantIds) ? $consultantIds[0] : null,
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'gender' => 'female',
                'consultant_pref' => 'female',
                'consultant_id' => !empty($consultantIds) ? ($consultantIds[1] ?? $consultantIds[0]) : null,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}

