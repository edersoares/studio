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
        $builder = $preset->getNamespacedFor('builder', $draft->name());
        $builderName = $preset->getNameFor('builder', $draft->name());
        $generator->namespace()->addUse($builder);

        $generator->class()->addComment('@method static ' . $builderName . ' query()');

        $newEloquentBuilder = $generator->class()->addMethod('newEloquentBuilder');
        $newEloquentBuilder->setReturnType($builder);
        $newEloquentBuilder->addParameter('query');
        $newEloquentBuilder->addBody('return new ' . $builderName . '($query);');
    }
}
