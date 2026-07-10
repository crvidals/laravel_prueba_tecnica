<div>
    @if ($successMessage)
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ $successMessage }}
        </div>
    @endif

    @php use App\Models\PlayerNote; @endphp
@can('create', PlayerNote::class)
        <div class="mb-8 rounded-lg border border-indigo-200 bg-indigo-50 p-6">
            <h3 class="mb-3 text-lg font-semibold text-gray-900">Add a Note</h3>
            <form wire:submit.prevent="save">
                <textarea
                    wire:model="note"
                    rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Write a note..."
                ></textarea>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex items-center justify-between">
                    <span class="text-sm text-gray-500">{{ 500 - mb_strlen($note) }} characters remaining</span>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-indigo-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:scale-95"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Publish Note
                    </button>
                </div>
            </form>
        </div>
    @endcan

    <div>
        <h3 class="mb-2 text-lg font-medium text-gray-900">Notes History</h3>
        @forelse ($this->notes as $note)
            <div class="mb-3 rounded-md border border-gray-200 bg-white p-4">
                <div class="mb-1 flex items-center justify-between text-sm text-gray-500">
                    <span>{{ $note->user->name }}</span>
                    <span>{{ $note->created_at->format('M d, Y H:i') }}</span>
                </div>
                <p class="text-gray-700">{{ $note->note }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">No notes have been added for this player yet.</p>
        @endforelse
    </div>
</div>
