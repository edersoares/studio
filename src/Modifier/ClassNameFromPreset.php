<?php

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Blueprint\Art;

class ClassNameFromPreset
{
    public function modify(Art $action): void
    {
        $class = $action->preset()->getNameFor(
            type: $action->draft()->type(),
            name: $action->draft()->name(),
        );

        $action->generator()->class($class);
    }
}
