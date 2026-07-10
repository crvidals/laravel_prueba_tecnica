<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'ShadowStrike',
            'LunarWolf',
            'BlazeFury',
            'StormChaser',
            'NightHawk',
        ];

        foreach ($names as $name) {
            Player::factory()->create(['name' => $name]);
        }
    }
}
