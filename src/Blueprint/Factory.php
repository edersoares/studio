<?php

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;
use Illuminate\Support\Str;

class Factory
{
    public static function make(string $type, string $name, array $context = []): string
    {
        $preset = config('studio.preset');

        $draft = new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name),
            'context' => $context,
        ]);

        $blueprint = new Blueprint();

        $preset = new Preset(['name' => $preset] + config('studio.presets.' . $preset, []));

        return PhpGeneratorFactory::new($draft, $blueprint, $preset)->generate();
    }
}
