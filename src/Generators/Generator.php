<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Draft;
use Dex\Laravel\Studio\Preset;

abstract class Generator
{
    protected Draft $draft;

    protected Preset $preset;

    protected bool $shouldGenerate = true;

    public function __construct(Draft $draft, Preset $preset)
    {
        $this->draft = $draft;
        $this->preset = $preset;
    }

    public function notGenerate(): void
    {
        $this->shouldGenerate = false;
    }

    public function shouldGenerate(): bool
    {
        return $this->shouldGenerate;
    }

    public function filename(): string
    {
        return $this->preset->getFilenameFor(
            type: $this->draft->type(),
            name: $this->draft->name(),
        );
    }

    abstract public function generate(): string;
}
