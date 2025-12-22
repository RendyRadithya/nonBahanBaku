<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Baris 1: Tambahkan import URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Baris 2: Tambahkan logika untuk memaksa HTTPS di lingkungan production (Railway)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}