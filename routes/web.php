<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;
use Livewire\Livewire;

// Livewire routes for subdirectory deployment

Livewire::setScriptRoute(function($handle) {
    return Route::get('/tiktokdictionary/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function($handle) {
    return Route::post('/tiktokdictionary/livewire/update', $handle);
});

// Main Routes

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (Protected by IsAdmin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/words/{word}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('words.edit');
    Route::put('/words/{word}', [\App\Http\Controllers\AdminController::class, 'update'])->name('words.update');
    Route::delete('/words/{word}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('words.destroy');
    Route::post('/words/{word}/lore', [\App\Http\Controllers\AdminController::class, 'storeLore'])->name('words.lore.store');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/word/{slug}', [WordController::class, 'show'])->name('word.show');
Route::get('/browse', [WordController::class, 'browse'])->name('word.browse');
Route::get('/submit', [WordController::class, 'create'])->name('word.create');
Route::post('/submit', [WordController::class, 'store'])->name('word.store');
Route::get('/check-word', [WordController::class, 'check'])->name('word.check');
Route::post('/word/{word}/definition', [WordController::class, 'storeDefinition'])->name('definition.store');
