<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | EDUCATIONAL CORNER (LEARN)
        |--------------------------------------------------------------------------
        */
        Resource::create([
            'title' => 'Understanding Stress vs Anxiety',
            'description' => 'A simple explanation of how stress differs from anxiety and how they affect the mind.',
            'url' => 'https://example.com/stress-vs-anxiety',
            'is_featured' => false,
            'section' => 'Educational Corner',
        ]);

        Resource::create([
            'title' => 'What is Burnout?',
            'description' => 'Signs, causes, and recovery strategies for burnout.',
            'url' => 'https://example.com/burnout',
            'is_featured' => false,
            'section' => 'Educational Corner',
        ]);

        Resource::create([
            'title' => 'How Sleep Affects Mental Health',
            'description' => 'Learn how sleep impacts mood, focus, and emotional balance.',
            'url' => 'https://example.com/sleep-and-mental-health',
            'is_featured' => false,
            'section' => 'Educational Corner',
        ]);

        /*
        |--------------------------------------------------------------------------
        | COPING & SELF‑CARE STRATEGIES (DO)
        |--------------------------------------------------------------------------
        */
        Resource::create([
            'title' => '5-Minute Breathing Exercise',
            'description' => 'Guided box breathing to reduce stress and calm the mind.',
            'url' => 'https://example.com/breathing',
            'is_featured' => true,
            'section' => 'Coping & Self-Care Strategies',
        ]);

        Resource::create([
            'title' => '10-Minute Mindfulness Meditation',
            'description' => 'A guided meditation to help you stay grounded and present.',
            'url' => 'https://youtube.com/...',
            'is_featured' => true,
            'section' => 'Coping & Self-Care Strategies',
        ]);

        Resource::create([
            'title' => 'Healthy Sleep Habits',
            'description' => 'Practical tips to improve your sleep routine and reduce stress.',
            'url' => 'https://example.com/sleep-tips',
            'is_featured' => false,
            'section' => 'Coping & Self-Care Strategies',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GETTING HELP (CONNECT)
        |--------------------------------------------------------------------------
        */
        Resource::create([
            'title' => 'When to Seek Professional Help',
            'description' => 'A guide to recognizing when it’s time to reach out for support.',
            'url' => 'https://example.com/when-to-seek-help',
            'is_featured' => false,
            'section' => 'Getting Help',
        ]);

        Resource::create([
            'title' => 'How to Talk to a Counselor',
            'description' => 'Tips for preparing for your first counseling session.',
            'url' => 'https://example.com/talk-to-counselor',
            'is_featured' => false,
            'section' => 'Getting Help',
        ]);

        Resource::create([
            'title' => 'Support Hotlines & Emergency Contacts',
            'description' => 'A list of important mental health hotlines and crisis support numbers.',
            'url' => 'https://example.com/hotlines',
            'is_featured' => false,
            'section' => 'Getting Help',
        ]);
    }
}
