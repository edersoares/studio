<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Generators\PhpGenerator;
use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;

class Factory
{
    public static function generate(string $type, string $name, array $context = []): string
    {
        /** @var string $preset */
        $preset = config('studio.preset');

        return static::new($type, $name, $preset, $context)->generate();
    }

    public static function new(string $type, string $name, string $preset, array $context = []): PhpGenerator
    {
        return PhpGeneratorFactory::new(
            draft: static::draft($type, $name, $context),
            blueprint: static::blueprint(),
            preset: static::preset($preset),
        );
    }

    public static function draft(string $type, string $name, array $context = []): Draft
    {
        return new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => str($name)->slug()->value(),
            'context' => $context,
        ]);
    }

    public static function blueprint(array $blueprint = []): Blueprint
    {
        return new Blueprint($blueprint);
    }

    public static function preset(string $name): Preset
    {
        $preset = new Preset(['name' => $name]);

        /** @var array $extends */
        $extends = config("studio.presets.$name.extends", []);

        foreach ($extends as $extend) {
            /** @var array $config */
            $config = config("studio.presets.$extend", []);

            $preset->settedAll($config);
        }

        /** @var array $config */
        $config = config("studio.presets.$name", []);

        $preset->settedAll($config);

        return $preset;
    }
}
