<?php

use App\Models\User;
use App\Models\CheckIn;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows all checkins in a paginated list and allows delete', function () {
    $user = User::factory()->create();

    // create a few checkins
    for ($i = 0; $i < 5; $i++) {
        CheckIn::create([
            'user_id' => $user->id,
            'date' => now()->subDays($i)->toDateString(),
            'period' => $i % 2 == 0 ? 'Morning' : 'Evening',
            'mood' => 3 + ($i % 3),
            'note' => 'Entry ' . $i,
        ]);
    }

    $response = $this->actingAs($user)->get('/checkins');
    $response->assertOk();

    $response->assertSee('Entry 0', false);
    $response->assertSee('Entry 4', false);

    // Delete one and ensure it's removed
    $entry = CheckIn::where('user_id', $user->id)->first();
    $del = $this->actingAs($user)->delete('/checkin/' . $entry->id);
    $del->assertRedirect();
    $this->assertDatabaseMissing('check_ins', ['id' => $entry->id]);
});

it('navigates from dashboard View link to modal open URL', function () {
    $user = User::factory()->create();

    CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Evening',
        'mood' => 4,
        'note' => 'Modal entry',
    ]);

    $dashboard = $this->actingAs($user)->get('/dashboard');
    $dashboard->assertSee(route('checkin.index', ['open_date' => now()->toDateString(), 'open_period' => 'Evening']), false);

    // Simulate clicking the View link by following the URL
    $viewResp = $this->actingAs($user)->get(route('checkin.index', ['open_date' => now()->toDateString(), 'open_period' => 'Evening']));
    $viewResp->assertOk();
    $viewResp->assertSee('open-checkin', false);
});

it('allows deletion within 10 hours', function () {
    $user = User::factory()->create();

    $ci = CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Morning',
        'mood' => 3,
        'note' => 'Will be deleted',
    ]);

    // Simulate created_at 9 hours ago
    $ci->created_at = now()->subHours(9);
    $ci->save();

    $resp = $this->actingAs($user)->delete('/checkin/' . $ci->id);
    $resp->assertRedirect();
    $this->assertDatabaseMissing('check_ins', ['id' => $ci->id]);
});

it('prevents deletion after 10 hours', function () {
    $user = User::factory()->create();

    $ci = CheckIn::create([
        'user_id' => $user->id,
        'date' => now()->toDateString(),
        'period' => 'Morning',
        'mood' => 3,
        'note' => 'Too old to delete',
    ]);

    // Simulate created_at 11 hours ago
    $ci->created_at = now()->subHours(11);
    $ci->save();

    $resp = $this->actingAs($user)->delete('/checkin/' . $ci->id);
    $resp->assertRedirect();
    $resp->assertSessionHas('error');
    $this->assertDatabaseHas('check_ins', ['id' => $ci->id]);
});