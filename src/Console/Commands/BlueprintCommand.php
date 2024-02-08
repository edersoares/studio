<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\GenerateDumper;
use Illuminate\Console\Command;

class BlueprintCommand extends Command
{
    use CreateFileAfterGenerate;
    use GenerateDumper;

    protected $signature = 'blueprint {file} {--dump} {--file} {--preset=}';

    protected $description = 'Generate files from blueprint';

    public function handle(): int
    {
        $presetOption = $this->option('preset') ?? config('studio.preset');

        $file = require $this->argument('file');

        $blueprint = new Blueprint($file);
        $preset = new Preset(['name' => $presetOption] + config('studio.presets.' . $presetOption, []));

        if ($this->option('dump')) {
            $this->dump();
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
