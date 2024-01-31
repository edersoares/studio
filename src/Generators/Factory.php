<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Blueprint\Preset;

class Factory
{
    public static function new(string $type, string $name, string $preset): Generator
    {
        $config = config('studio.presets.' . $preset, []);
        $presetInstance = new Preset($preset, $config);

        $generator = new Generator(
            type: $type,
            name: $name,
            preset: $presetInstance,
        );

        event('generate:started', [$generator, $presetInstance]);
        event("generate:$type", [$generator, $presetInstance]);
        event('generate:finished', [$generator, $presetInstance]);

        return $generator;
    }
}
