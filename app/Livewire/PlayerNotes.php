<?php

namespace App\Livewire;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class PlayerNotes extends Component
{
    public int $playerId;

    public string $note = '';

    public ?string $successMessage = null;

    protected PlayerNoteRepositoryInterface $repository;

    protected function rules(): array
    {
        return [
            'note' => ['required', 'max:500'],
        ];
    }

    public function boot(PlayerNoteRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

    public function mount(int $playerId): void
    {
        $this->playerId = $playerId;
    }

    public function getNotesProperty(): Collection
    {
        return $this->repository->getNotesByPlayer($this->playerId);
    }

    public function save(): void
    {
        $this->authorize('create', PlayerNote::class);

        $this->validate();

        $this->repository->create([
            'player_id' => $this->playerId,
            'user_id' => auth()->id(),
            'note' => $this->note,
        ]);

        $this->note = '';
        $this->successMessage = 'Note created successfully.';
    }

    public function render(): View
    {
        return view('livewire.player-notes');
    }
}
