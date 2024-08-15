<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetTraits
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var array $traits */
        $traits = $preset->dotted("drafts.{$draft->type()}.traits", []);

        foreach ($traits as $trait) {
            $generator->namespace()->addUse($trait);
            $generator->trait($trait);
        }
    }
}
