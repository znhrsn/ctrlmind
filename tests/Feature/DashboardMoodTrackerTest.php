<?php

use App\Models\User;
use App\Models\CheckIn;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows mood trend and recent checkins on dashboard', function () {
    $user = User::factory()->create();

    // create some checkins across last few days
    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'morning',
        'mood' => 5,
        'note' => 'Great start',
    ]);

    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->subDays(1)->toDateString(),
        'period' => 'evening',
        'mood' => 3,
        'note' => 'Okay',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('Mood Trend', false);
    $response->assertSee('Recent Check-ins', false);
    $response->assertSee('Great start', false);
});