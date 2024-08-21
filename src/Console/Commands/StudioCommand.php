<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Factory;
use Illuminate\Console\Command;

class StudioCommand extends Command
{
    protected $signature = 'studio {file} {--dump} {--file} {--preset=}';

    protected $description = 'Generate all drafts from file';

    public function handle(): int
    {
        $file = require $this->argument('file');

        /** @var string $preset */
        $preset = $this->option('preset') ?? $file['preset'] ?? config('studio.preset');

        $blueprint = Factory::blueprint($file);

        $dump = $this->option('dump');
        $file = $this->option('file');

        foreach ($blueprint->drafts() as $draft) {
            foreach ($draft['generate'] ?? [] as $type) {
                $art = Factory::art($draft['name'], $type, $preset, $draft);

                if ($art->generator()->shouldGenerate() === false) {
                    continue; // @codeCoverageIgnore
                }

                $filename = $art->filename();
                $generate = $art->generate();

                if ($dump) {
                    $this->comment($filename);
                    $this->line($generate);
                }

                if ($file) {
                    $directory = dirname($filename);

                    if (is_dir($directory) === false) {
                        mkdir($directory, recursive: true); // @codeCoverageIgnore
                    }

                    $this->comment($filename);

                    file_put_contents($filename, $generate);
                }
            }
        }

        return self::SUCCESS;
    }
}
