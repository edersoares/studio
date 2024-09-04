<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Draft;
use Illuminate\Console\Command;

class StudioCommand extends Command
{
    protected $signature = 'studio {file} {--dump} {--file} {--preset=} {--only=*} {--force}';

    protected $description = 'Generate all drafts from file';

    public function handle(): int
    {
        $data = require $this->argument('file');

        /** @var string $preset */
        $preset = $this->option('preset') ?? $data['preset'] ?? config('studio.preset');

        $dump = $this->option('dump');
        $file = $this->option('file');
        $only = $this->option('only');
        $force = $this->option('force');

        foreach ($data['drafts'] as $draft) {
            foreach ($draft['generate'] ?? [] as $type) {
                if ($only && in_array($type, $only, true) === false) {
                    continue;
                }

                $art = Draft::new($draft['name'])->setAll($draft)->art($type, $preset);

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

                    $reuse = $art->preset()->boolean("drafts.{$art->draft()->type()}.reuse", true);
                    $reuse = $art->draft()->boolean('reuse', $reuse);
                    $reuse = $force ?: $reuse;

                    if (file_exists($filename) && $reuse === false) {
                        continue; // @codeCoverageIgnore
                    }

                    $this->comment($filename);

                    file_put_contents($filename, $generate);
                }
            }
        }

        return self::SUCCESS;
    }
}
