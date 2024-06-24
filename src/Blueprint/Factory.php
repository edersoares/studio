<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Generators\PhpGenerator;
use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;
use Illuminate\Support\Str;

class Factory
{
    public static function make(string $type, string $name, array $context = []): string
    {
        $preset = config('studio.preset');

        return static::new($type, $name, $preset, $context)->generate();
    }

    public static function new(string $type, string $name, string $preset, array $context = []): PhpGenerator
    {
        $extends = config('studio.presets.$preset.extends', '_');
        $presetConfig = config("studio.presets.$preset", []);
        $presetExtendsConfig = config("studio.presets.$extends", []);

        $draft = new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name),
            'context' => $context,
        ]);

        $blueprint = new Blueprint();

        $preset = new Preset(['name' => $preset]);

        $preset->settedAll($presetExtendsConfig);
        $preset->settedAll($presetConfig);

        return PhpGeneratorFactory::new($draft, $blueprint, $preset);
    }
}
