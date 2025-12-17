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

    // Ensure calendar entries appear in recent checkins summary (both entries should show)
    $response->assertSee('Great start', false);
    $response->assertSee('Okay', false);

    // Ensure period counts are displayed and normalized keys exist
    $response->assertSee('Survey Periods', false);
    $response->assertSee('Morning', false);
    $response->assertSee('Evening', false);

    // Daily Check-in section has been moved into the Mood Tracker; ensure the dashboard does not render a separate Daily Check-in block
    $response->assertDontSee('Daily Check-in');
    $response->assertSee("Start Today's Check-in", false);

    // Each recent item should have a View link to open the check-in modal for that date+period
    $response->assertSee(route('checkin.index', ['open_date' => now()->toDateString(), 'open_period' => 'morning']), false);
    $response->assertSee(route('checkin.index', ['open_date' => now()->subDays(1)->toDateString(), 'open_period' => 'evening']), false);

    // If multiple entries exist on the same date, show them individually in the recent list
    $user2 = User::factory()->create();
    CheckIn::create(['user_id' => $user2->id, 'date' => now()->toDateString(), 'period' => 'Morning', 'mood' => 2, 'note' => 'AM note']);
    CheckIn::create(['user_id' => $user2->id, 'date' => now()->toDateString(), 'period' => 'Evening', 'mood' => 4, 'note' => 'PM note']);

    $response2 = $this->actingAs($user2)->get('/dashboard');
    $response2->assertSee('AM note', false);
    $response2->assertSee('PM note', false);

    // Older entries should also be included in counts (not limited to the 30-day window)
    $oldUser = User::factory()->create();
    CheckIn::create(['user_id' => $oldUser->id, 'date' => now()->subDays(60)->toDateString(), 'period' => 'Evening', 'mood' => 5, 'note' => 'Old entry']);

    $oldResp = $this->actingAs($oldUser)->get('/dashboard');
    // View data should contain the counts that include the old entry
    $oldResp->assertViewHas('periodCounts', function($pc){ return ($pc['evening'] ?? 0) === 1; });
    $oldResp->assertViewHas('moodCounts', function($mc){ return ($mc[5] ?? 0) === 1; });
});