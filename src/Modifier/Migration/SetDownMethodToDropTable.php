<?php

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Blueprint\Art;

class SetDownMethodToDropTable extends AlterMigration
{
    protected function method(Art $art): string
    {
        return 'down';
    }

    protected function action(Art $art): string
    {
        return 'dropIfExists';
    }

    protected function content(Art $art): ?string
    {
        return null;
    }
}
