<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

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
}
