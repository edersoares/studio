<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Art;

class SetUpMethodToAlter extends AlterMigration
{
    protected function method(Art $art): string
    {
        return 'up';
    }

    protected function action(Art $art): string
    {
        return 'table';
    }
}
