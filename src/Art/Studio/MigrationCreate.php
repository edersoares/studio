<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Studio;

use Dex\Laravel\Studio\Art\Laravel\MigrationCreate as Laravel;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\Migration\SetColumnsToCreate;
use Dex\Laravel\Studio\Modifier\Migration\SetDownMethodToDropTable;

class MigrationCreate extends Laravel
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
            SetColumnsToCreate::class,
            SetDownMethodToDropTable::class,
        ];
    }
}
