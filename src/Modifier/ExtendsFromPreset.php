<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class ExtendsFromPreset
{
    public function modify(Art $art): void
    {
        $extends = $art->preset()->string("drafts.{$art->draft()->type()}.extends");
        $alias = $art->preset()->stringOrNull("drafts.{$art->draft()->type()}.extends:alias");

        if ($extends) {
            $art->generator()->namespace()->addUse($extends, $alias);
            $art->generator()->class()->setExtends($extends);
        }
    }
}
