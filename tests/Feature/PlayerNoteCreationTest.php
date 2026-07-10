<?php

namespace Tests\Feature;

use App\Livewire\PlayerNotes;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PlayerNoteCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_with_permission_can_create_a_note(): void
    {
        $user = User::factory()->create(['can_create_notes' => true]);
        $player = Player::factory()->create();

        $this->actingAs($user);

        Livewire::test(PlayerNotes::class, ['playerId' => $player->id])
            ->set('note', 'Test note content')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Note created successfully.');

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $player->id,
            'user_id' => $user->id,
            'note' => 'Test note content',
        ]);
    }
}
