<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlayerNoteSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $players = Player::all();

        foreach ($players as $player) {
            $noteCount = rand(3, 6);

            for ($i = 0; $i < $noteCount; $i++) {
                PlayerNote::factory()
                    ->for($player)
                    ->for($users->random())
                    ->create();
            }
        }
    }
}
