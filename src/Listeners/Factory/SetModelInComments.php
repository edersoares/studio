<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetModelInComments
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $class = $preset->getNameFor('model', $draft->name());
        $namespacedClass = $preset->getNamespacedFor('model', $draft->name());

        $generator->namespace()->addUse($namespacedClass);
        $generator->class()->addComment("@extends PhpGeneratorFactory<$class>");
    }
}
