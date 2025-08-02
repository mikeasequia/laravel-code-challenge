<?php

namespace App\Providers;

use App\Services\PolicyService;
use App\Services\RuleEvaluator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RuleEvaluator::class);
        $this->app->singleton(PolicyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register middleware
        $router = $this->app['router'];
    }
}
