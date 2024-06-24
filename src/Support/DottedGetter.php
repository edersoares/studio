<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
trait DottedGetter
{
    public function dotted(string $key, mixed $default = null): mixed
    {
        return data_get($this->all(), $key, $default);
    }

    public function setted(string $key, mixed $default = null): void
    {
        data_set($this->items, $key, $default);
    }

    public function settedAll(array $data): void
    {
        $dot = Arr::dot($data);

        foreach ($dot as $key => $value) {
            $this->setted($key, $value);
        }
    }
}
