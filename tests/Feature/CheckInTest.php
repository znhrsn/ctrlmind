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

it('does not allow creating a checkin for a past date', function () {
    $user = User::factory()->create();

    $yesterday = now()->subDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => $yesterday,
            'period' => 'afternoon',
            'mood' => 3,
            'note' => 'Late entry',
        ]);

    $response->assertSessionHasErrors();

    $this->assertDatabaseMissing('check_ins', [
        'user_id' => $user->id,
        'date' => $yesterday,
        'period' => 'afternoon',
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

it('opens the check-in modal when visiting the calendar with open_date param', function () {
    $user = User::factory()->create();

    $today = now()->toDateString();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?open_date=' . $today);

    $response->assertOk();
    // Check that the page contains the script that dispatches the open-checkin event for today
    $response->assertSee("open-checkin", false);
    $response->assertSee($today, false);

    // Ensure month/year header is present and centered id exists
    $response->assertSee('id="calendarMonth"', false);
    $response->assertSee(now()->format('F Y'));
});

it('does not auto-open modal for a non-today open_date param', function () {
    $user = User::factory()->create();

    $tomorrow = now()->addDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?open_date=' . $tomorrow);

    $response->assertOk();
    // Should not dispatch the open-checkin event for a non-today date
    $this->assertStringNotContainsString('open-checkin', $response->getContent());
});

it('does not allow creating a checkin for a future date', function () {
    $user = User::factory()->create();

    $tomorrow = now()->addDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => $tomorrow,
            'period' => 'afternoon',
            'mood' => 4,
            'note' => 'Attempt future note',
        ]);

    $response->assertSessionHasErrors('date');

    $this->assertDatabaseMissing('check_ins', [
        'user_id' => $user->id,
        'date' => $tomorrow,
    ]);
});

it('shows a specific month when month/year params are provided', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?month=11&year=2025');

    $response->assertOk();
    $response->assertSee('November 2025');
});

it('allows a user to delete their own checkin', function () {
    $user = User::factory()->create();

    $checkin = CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 3,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/checkin/' . $checkin->id);

    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('check_ins', [
        'id' => $checkin->id,
    ]);
});

it('stores an afternoon quick checkin with a short note', function () {
    $user = User::factory()->create();

    $note = 'Lots of meetings';

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'afternoon',
            'mood' => 3,
            'note' => $note,
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'afternoon',
        'mood' => 3,
        'note' => $note,
    ]);
});

it('prevents a user from deleting another users checkin', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $checkin = CheckIn::create([
        'user_id' => $other->id,
        'date' => now()->toDateString(),
        'period' => 'evening',
        'mood' => 2,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete('/checkin/' . $checkin->id);

    $response->assertStatus(403);

    $this->assertDatabaseHas('check_ins', [
        'id' => $checkin->id,
    ]);
});
