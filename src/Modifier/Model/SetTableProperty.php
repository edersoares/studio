<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Blueprint\Art;

class SetTableProperty
{
    public function modify(Art $art): void
    {
        $table = $art->draft()->string('table');

        if ($table) {
            $art->generator()->property('table')
                ->setProtected()
                ->setValue($table);
        }
    }
}
