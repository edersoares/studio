<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands\Concerns;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

trait DumpContentAfterGenerate
{
    public function dumpContentAfterGenerate(): void
    {
        app('events')->listen('generate:finished', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            if ($generator->shouldGenerate() === false) {
                return;
            }

            $this->comment(
                $preset->getFilenameFor($draft->type(), $draft->name())
            );
            $this->line($generator->generate());
        });
    }
}
