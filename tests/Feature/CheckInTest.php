<?php

use App\Models\User;
use App\Models\CheckIn;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // nothing special yet
});

it('storEs A Morning chEckin with EnErgy And focus', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'Morning',
            'mood' => 4,
            'energy' => 5,
            'focus' => 4,
            'note' => 'Morning feeling good',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Morning',
        'mood' => 4,
        'energy' => 5,
        'focus' => 4,
        'note' => 'Morning feeling good',
    ]);
});

it('storEs An EvEning rEflEction with sAtisfAction And rElAxAtion', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'Evening',
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
        'period' => 'Evening',
        'mood' => 3,
        'satisfaction' => 4,
        'relaxation' => 5,
    ]);
});

it('updAtEs An Existing chEckin for thE sAME dAtE And pEriod', function () {
    $user = User::factory()->create();

    // create initial
    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
        'mood' => 2,
        'satisfaction' => 2,
    ]);

    // update via post
    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => now()->toDateString(),
            'period' => 'Evening',
            'mood' => 5,
            'satisfaction' => 5,
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
        'mood' => 5,
        'satisfaction' => 5,
    ]);
});

it('dEfAults pEriod to currEnt timEfrAME whEn pEriod not providEd', function () {
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
        'period' => 'Morning',
        'mood' => 4,
        'energy' => 5,
    ]);

    \Carbon\Carbon::setTestNow();
});

it('allows creating a checkin for a past date', function () {
    $user = User::factory()->create();

    $yesterday = now()->subDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => $yesterday,
            'period' => 'Evening',
            'mood' => 4,
            'note' => 'Late entry from evening',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => $yesterday,
        'period' => 'Evening',
        'mood' => 4,
    ]);
});

it('shows pEriod bAdgEs on cAlEndAr cElls', function () {
    $user = User::factory()->create();

    // Create morning and evening checkins for today
    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Morning',
        'mood' => 4,
    ]);

    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
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

it('shows emoji and period badge for past evening entry', function () {
    $user = User::factory()->create();

    $yesterday = now()->subDay()->toDateString();

    CheckIn::create([
        'user_id' => $user->id,
        'date' => $yesterday,
        'period' => 'Evening',
        'mood' => 5,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/checkin');

    $response->assertOk();
    $response->assertSee('title="Evening"', false);
    $response->assertSee('😊', false);
});

it('sElEcts thE dAtE (highlights) whEn visiting thE cAlEndAr with opEn_dAtE pArAM but doEs not Auto-opEn thE ModAl', function () {
    $user = User::factory()->create();

    $today = now()->toDateString();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?open_date=' . $today);

    $response->assertOk();
    // The page should dispatch a select-date event to highlight the date, but should NOT auto-open the modal
    $response->assertSee("select-date", false);
    $this->assertStringNotContainsString('open-checkin', $response->getContent());
    $response->assertSee($today, false);

    // Ensure month/year header is present and centered id exists
    $response->assertSee('id="calendarMonth"', false);
    $response->assertSee(now()->format('F Y'));
});

it('doEs not Auto-opEn ModAl for A non-todAy opEn_dAtE pArAM', function () {
    $user = User::factory()->create();

    $tomorrow = now()->addDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?open_date=' . $tomorrow);

    $response->assertOk();
    // Should not dispatch the open-checkin event for a non-today date
    $this->assertStringNotContainsString('open-checkin', $response->getContent());
});

it('hAs A BAck link thAt rEturns to thE dAshboArd', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/checkin');

    $response->assertOk();
    // Ensure the Back link points to the dashboard route
    $response->assertSee('href="' . route('dashboard') . '"', false);
});

it('allows creating a checkin for a future date', function () {
    $user = User::factory()->create();

    $tomorrow = now()->addDay()->toDateString();

    $response = $this
        ->actingAs($user)
        ->post('/checkin', [
            'date' => $tomorrow,
            'period' => 'Morning',
            'mood' => 4,
            'note' => 'Attempt future note',
        ]);

    $response->assertSessionHas('success');

    $this->assertDatabaseHas('check_ins', [
        'user_id' => $user->id,
        'date' => $tomorrow,
    ]);
});

it('shows A spEcific Month whEn Month/yEAr pArAMs ArE providEd', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/checkin?month=11&year=2025');

    $response->assertOk();
    $response->assertSee('November 2025');
});

it('Allows A usEr to dElEtE thEir own chEckin', function () {
    $user = User::factory()->create();

    $checkin = CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
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



it('prEvEnts A usEr from dElEting AnothEr usErs chEckin', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $checkin = CheckIn::create([
        'user_id' => $other->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
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
