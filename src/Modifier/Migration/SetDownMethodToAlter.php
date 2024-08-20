<?php

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Blueprint\Art;

class SetDownMethodToAlter extends AlterMigration
{
    protected function method(Art $art): string
    {
        return 'down';
    }

    protected function action(Art $art): string
    {
        return 'table';
    }
}
