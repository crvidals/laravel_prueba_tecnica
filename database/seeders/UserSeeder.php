<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Alice Johnson',
            'email' => 'agent@example.com',
            'can_create_notes' => true,
        ]);

        User::factory()->create([
            'name' => 'Bob Martinez',
            'email' => 'supervisor@example.com',
            'can_create_notes' => true,
        ]);
    }
}
