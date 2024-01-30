<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Dex\Laravel\Studio\Generators\Factory;
use Dex\Laravel\Studio\Generators\Generator;
use Dex\Laravel\Studio\Presets\Preset;
use Illuminate\Database\Eloquent\Builder;
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

            $extends = $generator->preset()->getNamespacedFor('eloquent', $generator->name());

            $namespace->addUse($extends, 'Model');
            $class->setExtends($extends);

            Factory::new('eloquent', $generator->name(), $generator->preset()->name());
            Factory::new('builder', $generator->name(), $generator->preset()->name());
        });

        Event::listen('generate:eloquent', function (Generator $generator) {
            $namespace = $generator->namespace(
                $generator->config('eloquent.namespace'),
            );

            $class = $generator->class(
                $generator->preset()->getNameFor('eloquent', $generator->name())
            );

            $builder = $generator->preset()->getNamespacedFor('builder', $generator->name());
            $builderName = $generator->preset()->getNameFor('builder', $generator->name());
            $namespace->addUse($builder);

            $class->addComment('@method ' . $builderName . ' query()');

            $namespace->addUse(Model::class);
            $class->setExtends(Model::class);

            $namespace->addUse(SoftDeletes::class);
            $class->addTrait(SoftDeletes::class);

            $newEloquentBuilder = $class->addMethod('newEloquentBuilder');
            $newEloquentBuilder->setReturnType($builder);
            $newEloquentBuilder->addParameter('query');
            $newEloquentBuilder->addBody('return new ' . $builderName . '($query);');
        });

        Event::listen('generate:builder', function (Generator $generator, Preset $preset) {
            $namespace = $generator->namespace(
                $generator->config('builder.namespace'),
            );

            $class = $generator->class(
                $generator->preset()->getNameFor('builder', $generator->name())
            );

            $namespace->addUse(Builder::class);
            $class->setExtends(Builder::class);
        });
    }
}
