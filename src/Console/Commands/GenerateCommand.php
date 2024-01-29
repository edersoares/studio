<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

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
        $preset = $this->option('preset') ?? config('studio.preset');

        if ($this->option('dump')) {
            $events->listen('generate:finished', fn (Generator $generator) => $this->line($generator->generate()));
        }

        Factory::new($type, $name, $preset);

        $this->comment('Generate new files');

        return self::SUCCESS;
    }
}
