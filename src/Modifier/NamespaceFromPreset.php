<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class NamespaceFromPreset
{
    public function modify(Art $art): void
    {
        $namespace = $art->preset()->getNamespaceForType(
            $art->draft()->type()
        );

        if ($namespace) {
            $art->generator()->namespace($namespace);
        }
    }
}
