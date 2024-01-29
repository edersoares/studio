<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class GenerateCommand extends Command
{
    protected $signature = 'generate {type?} {name?} {--dump} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        [$type, $name] = $this->getTypeAndName();

        $generator = Generator::new($type, $name, $this->config() + [
            'dump' => $this->option('dump'),
            'preset' => $this->option('preset'),
        ]);

        if ($this->option('dump')) {
            $this->line($generator->generate());
        }

        $this->comment('Generate new files');

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
