<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Factory;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

class GenerateCommand extends Command
{
    protected $signature = 'generate {type} {name} {--dump} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(Dispatcher $events): int
    {
        $type = $this->argument('type');
        $name = $this->argument('name');
        $presetOption = $this->option('preset') ?? config('studio.preset');

        if ($this->option('dump')) {
            $events->listen('generate:finished', function (Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset) {
                $this->comment(
                    $preset->getNamespacedFor($generator->type(), $generator->name())
                );
                $this->line($generator->generate());
            });
        }

        $draft = new Draft([
            'type' => $type,
            'name' => $name,
        ]);

        $blueprint = new Blueprint();

        $preset = new Preset(['name' => $presetOption] + config('studio.presets.' . $presetOption, []));

        Factory::new($draft, $blueprint, $preset);

        return self::SUCCESS;
    }
}
