<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Art;

class SetHiddenProperty
{
    public function modify(Art $art): void
    {
        $attributes = $art->draft()->attributes();

        $hidden = array_filter($attributes, fn ($attribute) => $attribute['hidden'] ?? false);

        if ($hidden) {
            $art->generator()->property('hidden')
                ->setProtected()
                ->setValue(array_keys($hidden));
        }
    }
}
