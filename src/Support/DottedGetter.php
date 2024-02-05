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
    /**
     * @var Collection<string, mixed>
     */
    private Collection $dot;

    public function config(string $key): mixed
    {
        if (empty($this->dot)) {
            $this->dot = new Collection(Arr::dot($this->all()));
        }

        return $this->dot->get($key);
    }
}
