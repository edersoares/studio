<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Providers;

use Dex\Laravel\Studio\Console\Commands\BlueprintCommand;
use Dex\Laravel\Studio\Console\Commands\GenerateCommand;
use Illuminate\Support\ServiceProvider;

class StudioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BlueprintCommand::class,
                GenerateCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->app->register(LaravelServiceProvider::class);

        $this->mergeConfigFrom(__DIR__ . '/../../config/studio.php', 'studio');
    }
}
