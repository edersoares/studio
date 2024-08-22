<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class ExtendsFromPreset
{
    public function modify(Art $action): void
    {
        $extends = $action->preset()->string("drafts.{$action->draft()->type()}.extends");
        $alias = $action->preset()->stringOrNull("drafts.{$action->draft()->type()}.extends:alias");

        if ($extends) {
            $action->generator()->namespace()->addUse($extends, $alias);
            $action->generator()->class()->setExtends($extends);
        }
    }
}
