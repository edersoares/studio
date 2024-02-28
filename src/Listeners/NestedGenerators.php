<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;

class NestedGenerators
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var array $nested */
        $nested = $preset->dotted("{$draft->type()}.nested", []);

        foreach ($nested as $type) {
            $draft = $draft->merge([
                'type' => $type,
            ]);

            PhpGeneratorFactory::new($draft, $blueprint, $preset);
        }
    }
}
