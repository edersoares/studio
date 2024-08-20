<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Generators\Generator;

abstract class Art
{
    public function __construct(
        protected readonly Draft $draft,
        protected readonly Preset $preset,
    ) {}

    abstract public function generator(): Generator;

    public function filename(): string
    {
        return $this->generator()->filename();
    }

    public function generate(): string
    {
        $this->applyModifiers();

        return $this->generator()->generate();
    }

    public function draft(): Draft
    {
        return $this->draft;
    }

    public function preset(): Preset
    {
        return $this->preset;
    }

    public function apply(): array
    {
        return [];
    }

    protected function applyModifiers(): void
    {
        $classes = $this->apply();

        foreach ($classes as $class) {
            app($class)->modify($this);
        }
    }
}
