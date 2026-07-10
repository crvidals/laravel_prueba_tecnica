<?php

namespace App\Policies;

use App\Models\PlayerNote;
use App\Models\User;

class PlayerNotePolicy
{
    public function create(User $user): bool
    {
        return $user->can_create_notes;
    }
}
