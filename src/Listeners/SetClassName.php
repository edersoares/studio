<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetClassName
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $generator->class(
            $preset->getNameFor($draft->type(), $draft->name())
        );
    }
}
