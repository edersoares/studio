<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

use Illuminate\Support\Collection;

/**
 * @mixin Collection
 */
trait TypedGetter
{
    public function string(string $key, string $default = ''): string
    {
        return (string) $this->get($key, $default);
    }

    public function array(string $key, array $default = []): array
    {
        return (array) $this->get($key, $default);
    }
}
