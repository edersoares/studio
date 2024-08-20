<?php

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Blueprint\Art;

class NamespaceFromPreset
{
    public function modify(Art $action): void
    {
        $namespace = $action->preset()->getNamespaceForType(
            $action->draft()->type()
        );

        if ($namespace) {
            $action->generator()->namespace($namespace);
        }
    }
}
