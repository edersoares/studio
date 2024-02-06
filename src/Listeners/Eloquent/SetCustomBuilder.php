<?php

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetCustomBuilder
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $builder = $generator->preset()->getNamespacedFor('builder', $draft->name());
        $builderName = $generator->preset()->getNameFor('builder', $draft->name());
        $generator->namespace()->addUse($builder);

        $generator->class()->addComment('@method ' . $builderName . ' query()');

        $newEloquentBuilder = $generator->class()->addMethod('newEloquentBuilder');
        $newEloquentBuilder->setReturnType($builder);
        $newEloquentBuilder->addParameter('query');
        $newEloquentBuilder->addBody('return new ' . $builderName . '($query);');
    }
}
