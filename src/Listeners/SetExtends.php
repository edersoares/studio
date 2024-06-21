<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetExtends
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var string $extends */
        $extends = $preset->dotted("{$draft->type()}.extends");

        /** @var string $alias */
        $alias = $preset->dotted("{$draft->type()}.extends:alias");

        if ($extends) {
            $generator->namespace()->addUse($extends, $alias);
            $generator->class()->setExtends($extends);
        }
    }
}
