<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;

// Main Routes

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (Protected by IsAdmin Middleware)
// Admin Routes (Protected by IsAdmin Middleware)
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
    // Dashboard (New Livewire Component)
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Foundation Routes for Phase 17/18
    Route::get('words', \App\Livewire\Admin\Words\Index::class)->name('admin.words'); // Placeholder
    Route::get('definitions', \App\Livewire\Admin\Definitions\Index::class)->name('admin.definitions'); // Placeholder
    Route::get('users', \App\Livewire\Admin\Users\Index::class)->name('admin.users'); // Placeholder
    Route::get('categories', \App\Livewire\Admin\Categories\Index::class)->name('admin.categories'); // Placeholder
    Route::get('settings', \App\Livewire\Admin\Settings\Index::class)->name('admin.settings'); // Placeholder

    /* 
    // OLD ROUTES (Migrating)
    Route::get('words', \App\Livewire\Admin\Words\Index::class)->name('admin.words.index');
    ...
    */
    
    // Word Edit (Livewire Component)
    Route::get('words/{word}/edit', \App\Livewire\Admin\Words\Edit::class)->name('admin.words.edit');
});

Route::get('/u/{username}', \App\Livewire\User\Profile::class)->name('user.profile');
Route::get('/feed', \App\Livewire\Explore\VerticalFeed::class)->name('explore.feed');
Route::get('/invest', \App\Livewire\Tools\InvestorDashboard::class)->name('tools.investor');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/word/{slug}', [WordController::class, 'show'])->name('word.show');
Route::get('/browse', [WordController::class, 'browse'])->name('word.browse');
Route::get('/submit', [WordController::class, 'create'])->name('word.create');
Route::post('/submit', [WordController::class, 'store'])->name('word.store');
Route::get('/check-word', [WordController::class, 'check'])->name('word.check');
Route::post('/word/{word}/definition', [WordController::class, 'storeDefinition'])->name('definition.store');
