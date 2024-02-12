<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands\Concerns;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Console\Command;

/**
 * @mixin Command
 */
trait CreateFileAfterGenerate
{
    public function createFileAfterGenerate(): void
    {
        app('events')->listen('generate:finished', function (PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            if ($generator->shouldGenerate() === false) {
                return;
            }

            $filename = $preset->getFilenameFor($draft->type(), $draft->name());
            $directory = dirname($filename);

            if (is_dir($directory)) {
                return;
            }

            mkdir($directory, recursive: true);
        });

        app('events')->listen('generate:finished', function (PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
            if ($generator->shouldGenerate() === false) {
                return;
            }

            $filename = $preset->getFilenameFor($draft->type(), $draft->name());

            $this->comment($filename);

            file_put_contents($filename, $generator->generate());
        });
    }
}
