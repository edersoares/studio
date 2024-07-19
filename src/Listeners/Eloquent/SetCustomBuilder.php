<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Eloquent\HasBuilder;

class SetCustomBuilder
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $name = $preset->getModelNameFor('eloquent', $draft->name());
        $builder = $preset->getNamespacedFor('builder', $name);
        $builderName = $preset->getNameFor('builder', $name);

        $generator->namespace()->addUse($builder);
        $generator->namespace()->addUse(HasBuilder::class);

        $generator->class()
            ->addTrait(HasBuilder::class)
            ->addComment("@use HasBuilder<$builderName>");

        $generator->class()
            ->addProperty('builder', $builderName . '::class')
            ->setType('string')
            ->setProtected()
            ->setStatic();
    }
}
