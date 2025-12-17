<?php

use App\Models\User;
use App\Models\JournalEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows shared journal users and supports searching by name', function () {
    $consultant = User::factory()->create(['role' => 'consultant']);

    $u1 = User::factory()->create(['name' => 'Mia Li']);
    $u2 = User::factory()->create(['name' => 'John Doe']);

    JournalEntry::create(['user_id' => $u1->id, 'reflection' => 'Shared by Mia', 'shared_with_consultant' => true]);
    JournalEntry::create(['user_id' => $u2->id, 'reflection' => 'Shared by John', 'shared_with_consultant' => true]);

    $resp = $this->actingAs($consultant)->get('/consultant/shared-journals');
    $resp->assertOk();
    $resp->assertSee('Mia Li', false);
    $resp->assertSee('John Doe', false);

    // search for Mia Li only
    $search = $this->actingAs($consultant)->get('/consultant/shared-journals?q=mia li');
    $search->assertOk();
    $search->assertSee('Mia Li', false);
    $search->assertDontSee('John Doe', false);
});

it('shows shared entries when selecting a user', function () {
    $consultant = User::factory()->create(['role' => 'consultant']);

    $u1 = User::factory()->create(['name' => 'Mia Li']);

    $entry = JournalEntry::create(['user_id' => $u1->id, 'reflection' => 'Shared by Mia', 'shared_with_consultant' => true]);

    $resp = $this->actingAs($consultant)->get('/consultant/shared-journals?user_id=' . $u1->id);
    $resp->assertOk();
    $resp->assertSee('Shared by Mia', false);
});