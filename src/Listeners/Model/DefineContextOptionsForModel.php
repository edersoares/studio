<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Model;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Factory;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

/**
 * @codeCoverageIgnore
 */
class DefineContextOptionsForModel
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        /** @var array $options */
        $options = $draft->dotted('context.options', []);

        if (in_array('eloquent', $options, true)) {
            $name = $preset->getNameFor('eloquent', $draft->name());
            $namespaced = $preset->getNamespacedFor('eloquent', $draft->name());
            $preset->setted('model.extends', $namespaced);
            $preset->setted('model.extends:alias', 'Eloquent');

            Factory::new('eloquent', $name, $preset->name());
        }

        if (in_array('builder', $options, true)) {
            $name = $preset->getNameFor('builder', $draft->name());

            Factory::new('builder', $name, $preset->name());
        }
    }
}
