<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetModelProperty
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $name = $preset->trim($draft->name(), 'Factory');

        $modelNamespaced = $preset->getNamespacedFor('model', $name);
        $model = $preset->getNameFor('model', $name);

        $generator->namespace()->addUse($modelNamespaced);

        $generator->class()
            ->addProperty('model')
            ->setProtected()
            ->setValue($model . '::class');
    }
}
