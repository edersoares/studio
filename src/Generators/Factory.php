<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Presets\Preset;

class Factory
{
    public static function new(string $type, string $name, string $preset): Generator
    {
        $config = config('studio.presets.' . $preset, []);

        $generator = new Generator(
            type: $type,
            name: $name,
            preset: new Preset($preset, $config),
        );

        event('generate:started', $generator);
        event("generate:$type", $generator);
        event('generate:finished', $generator);

        return $generator;
    }
}
