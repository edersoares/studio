<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Laravel;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\Migration\SetDownMethodToAlter;
use Dex\Laravel\Studio\Modifier\Migration\SetUpMethodToAlter;

class MigrationForeign extends Art
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
            SetUpMethodToAlter::class,
            SetDownMethodToAlter::class,
        ];
    }
}
