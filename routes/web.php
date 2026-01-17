<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;

// Main Routes

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post'); // Keep for POST fallback if needed
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

    // Moderation
    Route::get('moderation', \App\Livewire\Admin\Moderation\Index::class)->name('admin.moderation');
    Route::get('reports', \App\Livewire\Admin\Reports\Index::class)->name('admin.reports');

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
Route::get('/translator', \App\Livewire\Tools\Translator::class)->name('tools.translator');

// Utility Routes
Route::get('/overview', function () {
    return response()->file(base_path('public/overview.html'));
});

// EMERGENCY: Fix Live Server Cache
Route::get('/fix-live', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache Cleared! The site should now read your new .env values. <a href="/">Go Home</a>';
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/word/{slug}', [WordController::class, 'show'])->name('word.show');
Route::get('/browse', [WordController::class, 'browse'])->name('word.browse');
Route::get('/search', [WordController::class, 'search'])->name('word.search');

// Submission Routes
Route::get('/submit', [WordController::class, 'create'])->name('word.create');

// AJAX/API checks
Route::get('/check-word', [WordController::class, 'check'])->name('word.check');
Route::post('/word/{word}/definition', [WordController::class, 'storeDefinition'])->name('definition.store');
