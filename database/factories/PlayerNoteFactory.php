<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerNoteFactory extends Factory
{
    private static array $sampleNotes = [
        'Player reported a bug with the inventory system. Needs further investigation.',
        'Follow-up on previous ticket: player is experiencing lag spikes during peak hours.',
        'Account recovery request processed successfully. Player was able to log in again.',
        'Player reached out about a missing purchase. Verified and granted the item.',
        'Suspicious activity detected on account. Temporarily suspended for review.',
        'Player requested a name change. Approved and processed.',
        'Reported another player for harassment. Evidence reviewed, action taken.',
        'Connection issues troubleshooting completed. Resolved by switching server region.',
        'Player is asking for a refund on a recent purchase. Escalated to supervisor.',
        'Technical issue with the leaderboard not updating. Submitted to dev team.',
        'Player cannot access the new expansion content. Ownership verified, access granted.',
        'Bug report: character stuck in geometry after fast travel. Force-unstuck applied.',
        'Player reports inappropriate behavior from a guild member. Logs reviewed.',
        'Payment issue resolved. Premium subscription reactivated.',
        'Player lost items due to server crash. Rollback performed.',
        'Two-factor authentication setup assistance provided.',
        'Player query about upcoming patch notes. Shared available information.',
        'Reported exploit in the trading system. Team notified for hotfix.',
        'Player account hacked. Recovery process initiated and completed.',
        'Performance optimization suggestions provided for low-end hardware.',
    ];

    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'user_id' => User::factory(),
            'note' => fake()->randomElement(self::$sampleNotes),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'updated_at' => fn (array $attrs) => $attrs['created_at'],
        ];
    }
}
