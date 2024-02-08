<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\GenerateDumper;
use Dex\Laravel\Studio\Generators\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateCommand extends Command
{
    use CreateFileAfterGenerate;
    use GenerateDumper;

    protected $signature = 'generate {type} {name} {--dump} {--file} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        $type = $this->argument('type');
        $name = $this->argument('name');
        $presetOption = $this->option('preset') ?? config('studio.preset');

        if ($this->option('dump')) {
            $this->dump();
        }

        if ($this->option('file')) {
            $this->createFileAfterGenerate();
        }

        $draft = new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name),
        ]);

        $blueprint = new Blueprint();

        $preset = new Preset(['name' => $presetOption] + config('studio.presets.' . $presetOption, []));

        Factory::new($draft, $blueprint, $preset);

        return self::SUCCESS;
    }
}
