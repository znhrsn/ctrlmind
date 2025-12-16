<?php

use App\Models\User;
use App\Models\CheckIn;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // nothing special yet
});

it('stores a morning checkin with energy and focus', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'morning',
            'mood' => 4,
            'energy' => 5,
            'focus' => 4,
            'note' => 'Morning feeling good',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'morning',
        'mood' => 4,
        'energy' => 5,
        'focus' => 4,
        'note' => 'Morning feeling good',
    ]);
});

it('stores an evening reflection with satisfaction and relaxation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'evening',
            'mood' => 3,
            'satisfaction' => 4,
            'self_kindness' => 3,
            'relaxation' => 5,
            'note' => 'Evening reflection',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 3,
        'satisfaction' => 4,
        'relaxation' => 5,
    ]);
});

it('updates an existing checkin for the same date and period', function () {
    $user = User::factory()->create();

    // create initial
    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 2,
        'satisfaction' => 2,
    ]);

    // update via post
    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'evening',
            'mood' => 5,
            'satisfaction' => 5,
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 5,
        'satisfaction' => 5,
    ]);
});

it('defaults period to current timeframe when period not provided', function () {
    $user = User::factory()->create();

    // Freeze time to a specific hour so we can assert inferred period
    \Carbon\Carbon::setTestNow(\Carbon\Carbon::create(2025, 12, 16, 9, 0, 0)); // 09:00 -> morning

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'mood' => 4,
            'energy' => 5,
            'focus' => 4,
            'note' => 'Auto period test',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'morning',
        'mood' => 4,
        'energy' => 5,
    ]);

    \Carbon\Carbon::setTestNow();
});

it('allows overriding period when editing a past date', function () {
    $user = User::factory()->create();

    $yesterday = now()->subDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => $yesterday,
            // user chooses the afternoon slot for the past date
            'period' => 'afternoon',
            'mood' => 3,
            'note' => 'Late entry',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => $yesterday,
        'period' => 'afternoon',
        'mood' => 3,
    ]);
});

it('shows period badges on calendar cells', function () {
    $user = User::factory()->create();

    // Create morning and evening checkins for today
    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'morning',
        'mood' => 4,
    ]);

    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 3,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/checkin');

    $response->assertOk();
    // Assert that Morning and Evening badges appear in the rendered HTML
    $response->assertSee('title="Morning"', false);
    $response->assertSee('title="Evening"', false);
});
