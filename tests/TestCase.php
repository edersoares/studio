<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Tests;

use Dex\Laravel\Studio\Providers\StudioServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Providers\WorkbenchServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dex\\Laravel\\Studio\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        Factory::guessModelNamesUsing(
            fn ($factory) => 'Dex\\Laravel\\Studio\\Models\\' . Str::replaceLast('Factory', '', class_basename($factory))
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            StudioServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
