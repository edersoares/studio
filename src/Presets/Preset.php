<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Presets;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Preset extends Collection
{
    private Collection $dot;

    private string $name;

    public function __construct(string $name, $items = [])
    {
        parent::__construct($items);

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function config(string $key)
    {
        if (empty($this->dot)) {
            $this->dot = new Collection(Arr::dot($this->all()));
        }

        return $this->dot->get($key);
    }

    public function getNameFor(string $type, string $name): string
    {
        return $this->config("$type.prefix") . $name . $this->config("$type.suffix");
    }

    public function getNamespacedFor(string $type, string $name): string
    {
        return $this->config("$type.namespace") . '\\' . $this->getNameFor($type, $name);
    }
}
