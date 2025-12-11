<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- ADICIONADO

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
        // Se estiver em produção (Railway), força tudo para HTTPS
        if($this->app->environment('production')) {
            URL::forceScheme('https');
            config(['fortify.home' => '/dashboard']);
        }
        
    }
}