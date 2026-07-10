<?php

use App\Http\Controllers\ProfileController;
use App\Models\Player;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/players', function () {
        $players = Player::withCount('playerNotes')->get();
        return view('players.index', ['players' => $players]);
    })->name('players.index');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->get('/players/{player}/notes', function (Player $player) {
    $player->loadCount('playerNotes');
    return view('players.notes', ['player' => $player]);
})->name('players.notes');
