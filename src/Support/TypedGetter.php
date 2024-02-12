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
        /** @var string $string */
        $string = $this->get($key, $default);

        return $string;
    }

    public function array(string $key, array $default = []): array
    {
        /** @var array $array */
        $array = $this->get($key, $default);

        return $array;
    }
}
