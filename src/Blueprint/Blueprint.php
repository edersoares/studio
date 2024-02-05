<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Generator;
use Illuminate\Support\Collection;

/**
 * @extends Collection<string, mixed>
 */
class Blueprint extends Collection
{
    public function drafts(): Generator
    {
        /** @var array $drafts */
        $drafts = $this->get('drafts');

        foreach ($drafts as $slug => $draft) {
            yield new Draft([
                'slug' => $slug,
                'name' => $draft['name'] ?? $slug,
            ] + $draft);
        }
    }
}
