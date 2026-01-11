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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/word/{slug}', [WordController::class, 'show'])->name('word.show');
Route::get('/browse', [WordController::class, 'browse'])->name('word.browse');
Route::get('/submit', [WordController::class, 'create'])->name('word.create');
Route::post('/submit', [WordController::class, 'store'])->name('word.store');
Route::get('/check-word', [WordController::class, 'check'])->name('word.check');
Route::post('/word/{word}/definition', [WordController::class, 'storeDefinition'])->name('definition.store');
