<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Admin role blade directive
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role == UserRole::Admin;
        });

        // User role blade directive
        Blade::if('user', function () {
            return auth()->check() && auth()->user()->role == UserRole::User;
        });
    }
}
