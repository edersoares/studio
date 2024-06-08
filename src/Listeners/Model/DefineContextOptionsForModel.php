<?php

namespace Dex\Laravel\Studio\Listeners\Model;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Factory;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class DefineContextOptionsForModel
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $options = $draft->dotted('context.options', []);

        if (in_array('eloquent', $options)) {
            $name = $preset->getNameFor('eloquent', $draft->name());
            $namespaced = $preset->getNamespacedFor('eloquent', $draft->name());
            $preset->setted('model.extends', $namespaced);

            Factory::make('eloquent', $name);
        }

        if (in_array('builder', $options)) {
            $name = $preset->getNameFor('builder', $draft->name());

            Factory::make('builder', $name);
        }
    }
}
