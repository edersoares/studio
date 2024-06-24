<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Factory;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\DumpContentAfterGenerate;
use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    use CreateFileAfterGenerate;
    use DumpContentAfterGenerate;

    protected $signature = 'generate {type} {name} {context?*} {--dump} {--file} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        $type = $this->argument('type');
        $name = $this->argument('name');
        $preset = $this->option('preset') ?? config('studio.preset');

        $context = $this->argument('context');

        if ($this->option('dump')) {
            $this->dumpContentAfterGenerate();
        }

        if ($this->option('file')) {
            $this->createFileAfterGenerate();
        }

        Factory::new($type, $name, $preset, [
            'options' => $context,
        ]);

        return self::SUCCESS;
    }
}
