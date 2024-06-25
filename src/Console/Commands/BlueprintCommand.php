<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Factory;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\DumpContentAfterGenerate;
use Illuminate\Console\Command;

class BlueprintCommand extends Command
{
    use CreateFileAfterGenerate;
    use DumpContentAfterGenerate;

    protected $signature = 'blueprint {file} {--dump} {--file} {--preset=}';

    protected $description = 'Generate files from blueprint';

    public function handle(): int
    {
        /** @var string $presetName */
        $presetName = $this->option('preset') ?? config('studio.preset');

        $file = require $this->argument('file');

        $blueprint = Factory::blueprint($file);
        $preset = Factory::preset($presetName);

        if ($this->option('dump')) {
            $this->dumpContentAfterGenerate();
        }

        if ($this->option('file')) {
            $this->createFileAfterGenerate();
        }

        event('blueprint', [$blueprint, $preset]);

        foreach ($blueprint->drafts() as $draft) {
            event('blueprint:draft', [$draft, $blueprint, $preset]);
        }

        return self::SUCCESS;
    }
}
