<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Payments\PaymentGatewayInterface::class,
            \App\Services\Payments\PayphoneService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // GLOBAL FIX FOR LIVEWIRE & ASSETS (Local & Ngrok)
        // Always force the asset/app URL to match the current request root.
        
        // Register Layout Component
        \Illuminate\Support\Facades\Blade::component('layouts.theme.app', 'theme-layout');

        // This ensures Tenants use their subdomain and Ngrok uses its tunnel URL.
        
        if (!app()->runningInConsole()) {
            $currentRoot = request()->root(); 

            // Safer HTTPS Force (Essential for CloudPanel/Nginx Proxy)
            // Fixes "Too Many Redirects" when Nginx terminates SSL but Laravel doesn't know.
            if (app()->environment('production') || str_contains(request()->header('Host'), 'facta.ec')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            } else if (str_contains(request()->header('Host'), 'ngrok') || request()->header('X-Forwarded-Proto') === 'https') {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }

            config(['app.asset_url' => $currentRoot]);
            config(['livewire.app_url' => $currentRoot]);
            config(['app.url' => $currentRoot]); // FORCE app.url to match current domain
        }



    }
}
