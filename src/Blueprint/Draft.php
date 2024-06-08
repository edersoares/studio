<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Support\DottedGetter;
use Dex\Laravel\Studio\Support\TypedGetter;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * @extends Collection<string, mixed>
 */
class Draft extends Collection
{
    use DottedGetter;
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

        if ($this->has('slug') === false) {
            throw new InvalidArgumentException('Missing [slug] key');
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

    public function slug(): string
    {
        return $this->string('slug');
    }

    public static function new(string $name): Model
    {
        return new Model($name);
    }
}
