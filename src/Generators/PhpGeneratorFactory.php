<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Draft;
use Dex\Laravel\Studio\Preset;

class PhpGeneratorFactory
{
    public static function new(Draft $draft, Preset $preset): PhpGenerator
    {
        $generator = new PhpGenerator(
            draft: $draft,
            preset: $preset,
        );

        event('generate:started', [$generator, $draft, $preset]);
        event("generate:{$draft->type()}", [$generator, $draft, $preset]);
        event('generate:finished', [$generator, $draft, $preset]);

        return $generator;
    }
}
