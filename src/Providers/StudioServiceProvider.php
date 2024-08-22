<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Providers;

use Dex\Laravel\Studio\Console\Commands\StudioCommand;
use Illuminate\Support\ServiceProvider;

class StudioServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StudioCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/studio.php', 'studio');
    }
}
