<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Player Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ url('/players') }}" class="text-sm text-indigo-600 hover:text-indigo-900">&larr; Back to Players</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $player->name }}</h3>
                    <p class="text-sm text-gray-500">Total Notes: {{ $player->player_notes_count }}</p>
                </div>
                <div class="p-6 text-gray-900">
                    @livewire('player-notes', ['playerId' => $player->id], key($player->id))
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
