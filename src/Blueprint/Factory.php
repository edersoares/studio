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
        $draft = new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name),
            'context' => $context,
        ]);

        return PhpGeneratorFactory::new(
            draft: $draft,
            blueprint: new Blueprint(),
            preset: static::preset($preset),
        );
    }

    public static function preset(string $name): Preset
    {
        $preset = new Preset(['name' => $name]);

        $extends = config("studio.presets.$name.extends", []);

        foreach ($extends as $extend) {
            $preset->settedAll(
                config("studio.presets.$extend", [])
            );
        }

        $preset->settedAll(
            config("studio.presets.$name", [])
        );

        return $preset;
    }
}
