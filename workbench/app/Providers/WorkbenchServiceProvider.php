<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        Event::listen('generate:model', function (Generator $generator) {
            $namespace = $generator->namespace(
                $generator->config('model.namespace'),
            );

            $class = $generator->class(
                $generator->name()
            );

            $extends = $generator->config('eloquent.namespace') . '\\Eloquent\\' . $generator->name() . 'Eloquent';

            $namespace->addUse($extends, 'Model');
            $class->setExtends($extends);
        });

        Event::listen('generate:eloquent', function (Generator $generator) {
            $namespace = $generator->namespace(
                $generator->config('eloquent.namespace'),
            );

            $class = $generator->class(
                $generator->name()
            );

            $namespace->addUse(Model::class);
            $class->setExtends(Model::class);

            $namespace->addUse(SoftDeletes::class);
            $class->addTrait(SoftDeletes::class);

            $class->addProperty('fillable')->setType('array')->setProtected();

            $class->getProperty('fillable')->setValue(['name']);
        });
    }
}
