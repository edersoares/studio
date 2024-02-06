<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Factory;
use Dex\Laravel\Studio\Generators\Generator;

class NestedGenerators
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var array $nested */
        $nested = $preset->dotted("{$draft->type()}.nested");

        foreach ($nested as $type) {
            $draft = $draft->merge([
                'type' => $type,
            ]);

            Factory::new($draft, $blueprint, $preset);
        }
    }
}
