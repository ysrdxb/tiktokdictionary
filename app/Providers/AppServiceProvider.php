<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->usePublicPath($this->app->basePath());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Fixes mixed content & redirects)
        if ($this->app->environment('production') || request()->server('HTTPS') === 'on' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Livewire routes for subdirectory deployment
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/tiktokdictionary/livewire/livewire.js', $handle);
        });

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/tiktokdictionary/livewire/update', $handle);
        });
    }
}
