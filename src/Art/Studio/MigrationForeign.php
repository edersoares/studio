<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Studio;

use Dex\Laravel\Studio\Art\Laravel\MigrationForeign as Laravel;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\Migration\SetDownMethodForeign;
use Dex\Laravel\Studio\Modifier\Migration\SetUpMethodForeign;
use Dex\Laravel\Studio\Modifier\NamespaceFromPreset;

class MigrationForeign extends Laravel
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            NamespaceFromPreset::class,
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
            SetUpMethodForeign::class,
            SetDownMethodForeign::class,
        ];
    }
}
