<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetExtends
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var string $extends */
        $extends = $preset->dotted("{$draft->type()}.extends");

        $generator->namespace()->addUse($extends);
        $generator->class()->setExtends($extends);
    }
}
