<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier;

use Dex\Laravel\Studio\Art;

class TraitsFromPreset
{
    public function modify(Art $art): void
    {
        $traits = $art->preset()->array("drafts.{$art->draft()->type()}.traits");

        foreach ($traits as $trait) {
            $art->generator()->namespace()->addUse($trait);
            $art->generator()->trait($trait);
        }
    }
}
