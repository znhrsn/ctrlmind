<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a consultant to search their clients by name', function () {
    $consultant = User::factory()->create(['role' => 'consultant']);

    // create clients assigned to consultant
    $c1 = User::factory()->create(['name' => 'Mia Li', 'consultant_id' => $consultant->id]);
    $c2 = User::factory()->create(['name' => 'John Smith', 'consultant_id' => $consultant->id]);
    $c3 = User::factory()->create(['name' => 'Alice Jones', 'consultant_id' => $consultant->id]);

    $resp = $this->actingAs($consultant)->get('/consultant/dashboard?q=mia li');
    $resp->assertOk();
    $resp->assertSee('Mia Li', false);
    $resp->assertDontSee('John Smith', false);
    $resp->assertDontSee('Alice Jones', false);
});