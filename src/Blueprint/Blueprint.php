<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Generator;
use Illuminate\Support\Collection;

class Blueprint extends Collection
{
    public function drafts(): Generator
    {
        foreach ($this->get('drafts') as $slug => $draft) {
            yield new Draft([
                'slug' => $slug,
                'name' => $draft['name'] ?? $slug,
            ] + $draft);
        }
    }
}
