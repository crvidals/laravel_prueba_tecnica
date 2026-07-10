<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerNote extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerNoteFactory> */
    use HasFactory;
    protected $fillable = [
        'player_id',
        'user_id',
        'note',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
