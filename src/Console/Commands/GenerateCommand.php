<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Illuminate\Console\Command;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class GenerateCommand extends Command
{
    protected $signature = 'generate {arguments?*}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        $this->comment('Generate new files');

        [$type, $name] = $this->getTypeAndName();

        return self::SUCCESS;
    }

    private function preset(): string
    {
        $default = config('studio.preset');

        return $preset ?? $default;
    }

    private function types(): array
    {
        $preset = $this->preset();
        $config = config('studio.presets.' . $preset, []);

        return array_keys($config);
    }

    private function isInvalidType(string $type): bool
    {
        return !$this->isValidType($type);
    }

    private function isValidType(string $type): bool
    {
        return in_array($type, $this->types(), true);
    }

    private function getTypeAndName(): array
    {
        $arguments = $this->argument('arguments');

        $type = $arguments[0] ?? '';

        if ($this->isInvalidType($type)) {
            $type = select('What type of file would you generate?', $this->types());
        }

        $name = $arguments[1] ?? '';

        if (empty($name)) {
            $name = text('What name?', required: true);
        }

        return [$type, $name];
    }
}
