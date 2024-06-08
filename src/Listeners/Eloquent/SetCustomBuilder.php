<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetCustomBuilder
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $name = $preset->getModelNameFor('eloquent', $draft->name());
        $builder = $preset->getNamespacedFor('builder', $name);
        $builderName = $preset->getNameFor('builder', $name);
        $generator->namespace()->addUse($builder);

        $generator->class()->addComment('@method static ' . $builderName . ' query()');

        $newEloquentBuilder = $generator->class()->addMethod('newEloquentBuilder');
        $newEloquentBuilder->setReturnType($builder);
        $newEloquentBuilder->addParameter('query');
        $newEloquentBuilder->addBody('return new ' . $builderName . '($query);');
    }
}
