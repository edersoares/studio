<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands\Concerns;

use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Support\Facades\Event;

trait DumpContentAfterGenerate
{
    public function dumpContentAfterGenerate(): void
    {
        Event::listen('generate:finished', function (Generator $generator) {
            if ($generator->shouldGenerate() === false) {
                return;
            }

            $this->comment($generator->filename());
            $this->line($generator->generate());
        });
    }
}
