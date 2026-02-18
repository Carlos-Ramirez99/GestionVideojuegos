<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return 'Bienvenido, administrador';
})->middleware('auth', 'admin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::post('/ratings', [RatingController::class, 'store'])
    ->middleware('auth')
    ->name('ratings.store');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/games/create', [GamesController::class, 'create'])->name('games.create');
    Route::post('/games', [GamesController::class, 'store'])->name('games.store');

    Route::get('/games/{game}/edit', [GamesController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GamesController::class, 'update'])->name('games.update');

    Route::delete('/games/{game}', [GamesController::class, 'destroy'])->name('games.destroy');
});

Route::get('/games', [GamesController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GamesController::class, 'show'])->name('games.show');
require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::post('/games/{game}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


