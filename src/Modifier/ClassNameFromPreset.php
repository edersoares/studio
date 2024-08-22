<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

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
