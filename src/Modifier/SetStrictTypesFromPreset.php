<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class SetStrictTypesFromPreset
{
    public function modify(Art $art): void
    {
        if ($art->draft()->boolean('strict', true)) {
            $art->generator()->file()->setStrictTypes();
        }
    }
}
