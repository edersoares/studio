<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Support\TypedGetter;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Draft extends Collection
{
    use TypedGetter;

    public function __construct($items = [])
    {
        parent::__construct($items);

        if ($this->has('type') === false) {
            throw new InvalidArgumentException('Missing [type] key');
        }

        if ($this->has('name') === false) {
            throw new InvalidArgumentException('Missing [name] key');
        }
    }

    public function type(): string
    {
        return $this->string('type');
    }

    public function name(): string
    {
        return $this->string('name');
    }
}
