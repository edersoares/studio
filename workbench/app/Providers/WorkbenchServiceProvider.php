<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Factory;
use Dex\Laravel\Studio\Generators\Generator;
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
        Event::listen('generate:model', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $namespace = $generator->namespace(
                $generator->config('model.namespace'),
            );

            $class = $generator->class(
                $draft->string('name')
            );

            $extends = $generator->preset()->getNamespacedFor('eloquent', $draft->string('name'));

            $namespace->addUse($extends, 'Model');
            $class->setExtends($extends);

            Factory::new(new Draft([
                'type' => 'eloquent',
                'name' => $draft->string('name'),
                'slug' => $draft->string('slug'),
            ]), $blueprint, $preset);

            Factory::new(new Draft([
                'type' => 'builder',
                'name' => $draft->string('name'),
                'slug' => $draft->string('slug'),
            ]), $blueprint, $preset);
        });

        Event::listen('generate:eloquent', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $namespace = $generator->namespace(
                $generator->config('eloquent.namespace'),
            );

            $class = $generator->class(
                $generator->preset()->getNameFor('eloquent', $draft->name())
            );

            $builder = $generator->preset()->getNamespacedFor('builder', $draft->name());
            $builderName = $generator->preset()->getNameFor('builder', $draft->name());
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

        Event::listen('generate:builder', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $namespace = $generator->namespace(
                $generator->config('builder.namespace'),
            );

            $class = $generator->class(
                $generator->preset()->getNameFor('builder', $draft->name())
            );

            $namespace->addUse(Builder::class);
            $class->setExtends(Builder::class);
        });

        Event::listen('blueprint:draft', function (Draft $draft, Blueprint $blueprint, Preset $preset) {
            Factory::new($draft, $blueprint, $preset);
        });
    }
}
