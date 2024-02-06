<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetFillableProperty
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var array $attributes */
        $attributes = $draft->get('attributes', []);

        $fillable = array_filter($attributes, fn ($attribute) => $attribute['fillable'] ?? false);

        if ($fillable) {
            $generator->class()
                ->addProperty('fillable')
                ->setProtected()
                ->setValue(array_keys($fillable));
        }
    }
}
