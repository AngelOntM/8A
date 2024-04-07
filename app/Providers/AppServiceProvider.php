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
        $allowedIpAddresses = ['127.0.0.1', '10.0.0.2', '10.0.0.3', '10.0.1.2', '10.0.1.1'];
        if (in_array($clientIp, $allowedIpAddresses)) {
            config(['database.default' => 'vpn_connection']);
        } else {
            config(['database.default' => 'public_connection']);
        }
    }
}
