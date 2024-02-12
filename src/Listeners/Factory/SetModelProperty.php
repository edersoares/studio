<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetModelProperty
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $modelNamespaced = $preset->getNamespacedFor('model', $draft->name());
        $model = $preset->getNameFor('model', $draft->name());

        $generator->namespace()->addUse($modelNamespaced);

        $generator->class()
            ->addProperty('model')
            ->setProtected()
            ->setValue($model . '::class');
    }
}
