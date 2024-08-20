<?php

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Blueprint\Art;

class SetUpMethodToCreate extends AlterMigration
{
    protected function method(Art $art): string
    {
        return 'up';
    }

    protected function action(Art $art): string
    {
        return 'create';
    }
}
