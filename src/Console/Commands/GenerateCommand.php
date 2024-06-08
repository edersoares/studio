<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Console\Commands\Concerns\CreateFileAfterGenerate;
use Dex\Laravel\Studio\Console\Commands\Concerns\DumpContentAfterGenerate;
use Dex\Laravel\Studio\Generators\PhpGeneratorFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $presetOption = $this->option('preset') ?? config('studio.preset');

        $context = $this->argument('context');

        if ($this->option('dump')) {
            $this->dumpContentAfterGenerate();
        }

        if ($this->option('file')) {
            $this->createFileAfterGenerate();
        }

        $draft = new Draft([
            'type' => $type,
            'name' => $name,
            'slug' => Str::slug($name),
            'context' => [
                'options' => $context,
            ],
        ]);

        $blueprint = new Blueprint();

        $preset = new Preset(['name' => $presetOption] + config('studio.presets.' . $presetOption, []));

        PhpGeneratorFactory::new($draft, $blueprint, $preset);

        return self::SUCCESS;
    }
}
