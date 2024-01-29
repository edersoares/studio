<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class GenerateCommand extends Command
{
    protected $signature = 'generate {type?} {name?} {--dump} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        $this->comment('Generate new files');

        [$type, $name] = $this->getTypeAndName();

        $config = collect(Arr::dot([
            'type' => $type,
            'name' => $name,
            'config' => $this->config(),
        ]));

        $generator = new Generator($config);

        event("generate:$type", $generator);

        if ($this->option('dump')) {
            $this->line($generator->generate());
        }

        return self::SUCCESS;
    }

    private function config(): array
    {
        /** @var array $preset */
        $preset = config('studio.presets.' . $this->preset(), []);

        return $preset;
    }

    private function preset(): string
    {
        /** @var string $default */
        $default = config('studio.preset');
        $preset = $this->option('preset');

        return $preset ?: $default;
    }

    private function types(): array
    {
        return array_keys($this->config());
    }

    private function isInvalidType(?string $type): bool
    {
        return !$this->isValidType($type);
    }

    private function isValidType(?string $type): bool
    {
        return in_array($type, $this->types(), true);
    }

    private function getTypeAndName(): array
    {
        $type = $this->argument('type');

        if ($this->isInvalidType($type)) {
            $type = select('What type of file would you generate?', $this->types());
        }

        $name = $this->argument('name');

        if (empty($name)) {
            $name = text('What name?', required: true);
        }

        return [$type, $name];
    }
}
