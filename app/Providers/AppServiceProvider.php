<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $clientIp = request()->ip();

        if ($clientIp === '127.0.0.1') {
            config(['database.default' => 'vpn_connection']);
        } else {
            config(['database.default' => 'public_connection']);
        }
    }
}
