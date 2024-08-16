<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Factory;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\DumpContentAfterGenerate;
use Illuminate\Console\Command;

class StudioCommand extends Command
{
    use CreateFileAfterGenerate;
    use DumpContentAfterGenerate;

    protected $signature = 'studio {file} {--dump} {--file} {--preset=}';

    protected $description = 'Generate all drafts from file';

    public function handle(): int
    {
        $file = require $this->argument('file');

        /** @var string $presetName */
        $presetName = $this->option('preset') ?? $file['preset'] ?? config('studio.preset');

        $blueprint = Factory::blueprint($file);

        if ($this->option('dump')) {
            $this->dumpContentAfterGenerate();
        }

        if ($this->option('file')) {
            $this->createFileAfterGenerate();
        }

        foreach ($blueprint->drafts() as $draft) {
            foreach ($draft['generate'] ?? [] as $type) {
                Factory::new($type, $draft['name'], $presetName, $draft);
            }
        }

        return self::SUCCESS;
    }
}
