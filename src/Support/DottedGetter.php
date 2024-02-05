<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

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

    public function dotted(string $key): mixed
    {
        if (empty($this->dot)) {
            $this->dot = $this->dot();
        }

        return $this->dot->get($key);
    }
}
