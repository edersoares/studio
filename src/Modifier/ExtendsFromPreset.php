<?php

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Blueprint\Art;

class ExtendsFromPreset
{
    public function modify(Art $action): void
    {
        /** @var string $extends */
        $extends = $action->preset()->dotted("drafts.{$action->draft()->type()}.extends");

        /** @var string $alias */
        $alias = $action->preset()->dotted("drafts.{$action->draft()->type()}.extends:alias");

        if ($extends) {
            $action->generator()->namespace()->addUse($extends, $alias);
            $action->generator()->class()->setExtends($extends);
        }
    }
}
