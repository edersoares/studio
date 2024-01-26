<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Providers;

use Dex\Laravel\Studio\Console\Commands\GenerateCommand;
use Dex\Laravel\Studio\Console\Commands\StudioCommand;
use Illuminate\Support\ServiceProvider;

class StudioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/studio.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'studio');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                StudioCommand::class,
            ]);

            $this->loadMigrationsFrom([
                __DIR__ . '/../../database/migrations',
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/studio.php', 'studio');
    }
}
