<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands\Concerns;

use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

/**
 * @mixin Command
 */
trait CreateFileAfterGenerate
{
    public function createFileAfterGenerate(): void
    {
        Event::listen('generate:finished', function (Generator $generator) {
            if ($generator->shouldGenerate() === false) {
                return; // @codeCoverageIgnore
            }

            $filename = $generator->filename();
            $directory = dirname($filename);

            if (is_dir($directory)) {
                return;
            }

            mkdir($directory, recursive: true); // @codeCoverageIgnore
        });

        Event::listen('generate:finished', function (Generator $generator) {
            if ($generator->shouldGenerate() === false) {
                return; // @codeCoverageIgnore
            }

            $filename = $generator->filename();

            $this->comment($filename);

            file_put_contents($filename, $generator->generate());
        });
    }
}
