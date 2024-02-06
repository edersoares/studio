<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Factory;
use Dex\Laravel\Studio\Generators\Generator;
use Dex\Laravel\Studio\Listeners\NestedGenerators;
use Dex\Laravel\Studio\Listeners\SetClassName;
use Dex\Laravel\Studio\Listeners\SetExtends;
use Dex\Laravel\Studio\Listeners\SetFillableProperty;
use Dex\Laravel\Studio\Listeners\SetMethods;
use Dex\Laravel\Studio\Listeners\SetNamespace;
use Dex\Laravel\Studio\Listeners\SetTraits;
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
        Event::listen('generate:factory', SetNamespace::class);
        Event::listen('generate:factory', SetClassName::class);
        Event::listen('generate:factory', SetExtends::class);
        Event::listen('generate:factory', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $class = $preset->getNameFor('model', $draft->name());
            $namespacedClass = $preset->getNamespacedFor('model', $draft->name());

            $generator->namespace()->addUse($namespacedClass);
            $generator->class()->addComment("@extends Factory<$class>");
        });
        Event::listen('generate:factory', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $method = $generator->class()
                ->addMethod('definition')
                ->addBody('return [');

            $definition = $draft->get('attributes', []);

            foreach ($definition as $attribute => $options) {
                if (str_starts_with($options['factory'] ?? '', 'faker:')) {
                    $faker = explode(':', $options['factory']);

                    array_shift($faker);

                    $name = array_shift($faker);

                    $method->addBody('    \'' . $attribute . '\' => $this->faker->' . $name . '(...?),', [$faker]);
                }

                if (str_starts_with($options['factory'] ?? '', 'model:')) {
                    $faker = explode(':', $options['factory']);

                    array_shift($faker);

                    $model = array_shift($faker);

                    $namespacedModel = $preset->getNamespacedFor('model', $model);
                    $generator->namespace()->addUse($namespacedModel);

                    $method->addBody('    \'' . $attribute . '\' => fn () => ' . $model . '::factory()->create(),');
                }
            }

            $method->addBody('];');
        });

        Event::listen('generate:model', SetNamespace::class);
        Event::listen('generate:model', SetClassName::class);
        Event::listen('generate:model', NestedGenerators::class);

        Event::listen('generate:model', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $extends = $generator->preset()->getNamespacedFor('eloquent', $draft->string('name'));

            $generator->namespace()->addUse($extends, 'Model');
            $generator->class()->setExtends($extends);
        });

        Event::listen('generate:eloquent', SetNamespace::class);
        Event::listen('generate:eloquent', SetClassName::class);
        Event::listen('generate:eloquent', SetExtends::class);
        Event::listen('generate:eloquent', SetTraits::class);
        Event::listen('generate:eloquent', SetFillableProperty::class);

        Event::listen('generate:eloquent', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            $builder = $generator->preset()->getNamespacedFor('builder', $draft->name());
            $builderName = $generator->preset()->getNameFor('builder', $draft->name());
            $generator->namespace()->addUse($builder);

            $generator->class()->addComment('@method ' . $builderName . ' query()');

            $newEloquentBuilder = $generator->class()->addMethod('newEloquentBuilder');
            $newEloquentBuilder->setReturnType($builder);
            $newEloquentBuilder->addParameter('query');
            $newEloquentBuilder->addBody('return new ' . $builderName . '($query);');
        });

        Event::listen('generate:builder', SetNamespace::class);
        Event::listen('generate:builder', SetClassName::class);
        Event::listen('generate:builder', SetExtends::class);

        Event::listen('blueprint:draft', function (Draft $draft, Blueprint $blueprint, Preset $preset) {
            Factory::new($draft, $blueprint, $preset);
        });
    }
}
