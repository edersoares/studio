<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Blueprint\Art;

class SetFillableProperty
{
    public function modify(Art $art): void
    {
        $attributes = $art->draft()->array('attributes');

        $fillable = array_filter($attributes, fn ($attribute) => $attribute['fillable'] ?? false);

        if ($fillable) {
            $art->generator()->property('fillable')
                ->setProtected()
                ->setValue(array_keys($fillable));
        }
    }
}
