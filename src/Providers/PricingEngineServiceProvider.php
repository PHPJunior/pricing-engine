<?php

namespace PhpJunior\PricingEngine\Providers;

use Illuminate\Support\ServiceProvider;
use PhpJunior\PricingEngine\Services\PricingEngine;

class PricingEngineServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/pricing-engine.php', 'pricing-engine'
        );

        $this->app->bind('pricing-engine', function ($app) {
            return new PricingEngine(
                $app->make(\PhpJunior\PricingEngine\Repositories\PricingRuleRepository::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/pricing-engine.php' => config_path('pricing-engine.php'),
        ]);

        $this->publishesMigrations([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
