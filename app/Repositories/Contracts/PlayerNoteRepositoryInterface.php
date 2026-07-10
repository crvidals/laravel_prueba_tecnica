<?php

namespace App\Repositories\Contracts;

use App\Models\PlayerNote;
use Illuminate\Database\Eloquent\Collection;

interface PlayerNoteRepositoryInterface
{
    public function getNotesByPlayer(int $playerId): Collection;

    public function create(array $data): PlayerNote;
}
