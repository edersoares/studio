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
     * @return Generator<int, Draft>
     */
    public function drafts(): Generator
    {
        $drafts = $this->array('drafts');

        foreach ($drafts as $slug => $draft) {
            yield new Draft([
                'slug' => $slug,
                'name' => $draft['name'] ?? $slug,
            ] + $draft);
        }
    }
}
