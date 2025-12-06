<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Resource::insert([
            [
                'title' => '5-minute breathing exercise',
                'type' => 'activity',
                'topic' => 'anxiety',
                'description' => 'Guided box breathing to reduce stress.',
                'url' => 'https://example.com/breathing',
                'is_featured' => true,
            ],
            [
                'title' => 'Understanding burnout',
                'type' => 'article',
                'topic' => 'burnout',
                'description' => 'Signs, causes, and recovery strategies.',
                'url' => 'https://example.com/burnout',
                'is_featured' => false,
            ],
            [
                'title' => 'Sleep hygiene tips',
                'type' => 'article',
                'topic' => 'sleep',
                'description' => 'Practical ways to improve rest.',
                'url' => 'https://example.com/sleep',
                'is_featured' => false,
            ],
            [
                'title' => '10-minute mindfulness video',
                'type' => 'video',
                'topic' => 'mindfulness',
                'description' => 'Guided meditation to center attention.',
                'url' => 'https://youtube.com/...',
                'is_featured' => true,
            ],
        ]);
    }
}
