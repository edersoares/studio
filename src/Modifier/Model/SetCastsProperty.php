<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Art;

class SetCastsProperty
{
    public function modify(Art $art): void
    {
        $attributes = $art->draft()->attributes();

        $casts = array_filter($attributes, fn ($attribute) => $attribute['cast'] ?? false);
        $casts = array_map(fn ($attribute) => $attribute['cast'], $casts);

        if ($casts) {
            $art->generator()->property('casts')
                ->setProtected()
                ->setValue($casts);
        }
    }
}
