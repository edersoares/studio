<?php

namespace Dex\Laravel\Studio\Generators;

abstract class Generator
{
    protected bool $shouldGenerate = true;

    public function notGenerate(): void
    {
        $this->shouldGenerate = false;
    }

    public function shouldGenerate(): bool
    {
        return $this->shouldGenerate;
    }

    abstract public function generate(): string;
}
