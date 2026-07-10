<?php

namespace App\Repositories;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function __construct(
        private readonly PlayerNote $model
    ) {}

    public function getNotesByPlayer(int $playerId): Collection
    {
        return $this->model
            ->where('player_id', $playerId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function create(array $data): PlayerNote
    {
        return $this->model->create($data);
    }
}
