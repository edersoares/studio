<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;

class Factory
{
    public static function new(Draft $draft, Blueprint $blueprint, Preset $preset): Generator
    {
        $generator = new Generator(
            draft: $draft,
            blueprint: $blueprint,
            preset: $preset,
        );

        event('generate:started', [$generator, $draft, $blueprint, $preset]);
        event("generate:{$draft->type()}", [$generator, $draft, $blueprint, $preset]);
        event('generate:finished', [$generator, $draft, $blueprint, $preset]);

        return $generator;
    }
}
