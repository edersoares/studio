<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Support\TypedGetter;
use Generator;
use Illuminate\Support\Collection;

/**
 * @extends Collection<string, mixed>
 */
class Blueprint extends Collection
{
    use TypedGetter;

    /**
     * @return array
     */
    public function drafts(): array
    {
        return $this->array('drafts');
    }
}
