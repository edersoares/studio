<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Support\TypedGetter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Preset extends Collection
{
    use TypedGetter;

    private Collection $dot;

    public function __construct($items = [])
    {
        parent::__construct($items);

        if ($this->has('name') === false) {
            throw new InvalidArgumentException('Missing [name] key');
        }
    }

    public function name(): string
    {
        return $this->string('name');
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
