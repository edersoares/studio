<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class ClassNameFromPreset
{
    public function modify(Art $art): void
    {
        $class = $art->preset()->getNameFor(
            type: $art->draft()->type(),
            name: $art->draft()->name(),
        );

        $art->generator()->class($class);
    }
}
