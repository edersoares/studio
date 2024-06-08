<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen('generate:models', function (PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $generator->body(json_encode($blueprint->get('drafts')));
        });

        Event::listen('blueprint:draft', function (Draft $draft, Blueprint $blueprint, Preset $preset) {
            PhpGeneratorFactory::new($draft, $blueprint, $preset);
        });

        Event::listen('blueprint', function (Blueprint $blueprint, Preset $preset) {
            PhpGeneratorFactory::new(new Draft([
                'type' => 'models',
                'name' => 'models',
                'slug' => 'models',
            ]), $blueprint, $preset);
        });
    }
}
