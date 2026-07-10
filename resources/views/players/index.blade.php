<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Players') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-white px-6 py-5 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Players</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $players->count() }}</p>
                </div>
                <div class="rounded-lg bg-white px-6 py-5 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Notes</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $players->sum('player_notes_count') }}</p>
                </div>
                <div class="rounded-lg bg-white px-6 py-5 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">With Notes</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $players->where('player_notes_count', '>', 0)->count() }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Notes</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($players as $player)
                                <tr class="transition-colors hover:bg-indigo-50/50">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $player->id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-600">{{ substr($player->name, 0, 1) }}</span>
                                            <span class="font-medium text-gray-900">{{ $player->name }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($player->player_notes_count > 0)
                                            <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">{{ $player->player_notes_count }} notes</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-medium text-gray-500">0 notes</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a
                                            href="{{ route('players.notes', $player) }}"
                                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        >
                                            View Notes &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">No players found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
