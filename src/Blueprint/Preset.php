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
class Preset extends Collection
{
    use DottedGetter;
    use TypedGetter;

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

    public function getNameFor(string $type, string $name): string
    {
        return $this->dotted("$type.prefix") . $name . $this->dotted("$type.suffix");
    }

    public function getNamespacedFor(string $type, string $name): string
    {
        return $this->dotted("$type.namespace") . '\\' . $this->getNameFor($type, $name);
    }
}
