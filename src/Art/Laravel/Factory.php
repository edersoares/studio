<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Laravel;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\Factory\SetDefinitionMethod;
use Dex\Laravel\Studio\Modifier\Factory\SetModelProperty;
use Dex\Laravel\Studio\Modifier\NamespaceFromPreset;
use Dex\Laravel\Studio\Modifier\SetStrictTypesFromPreset;

class Factory extends Art
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            SetStrictTypesFromPreset::class,
            NamespaceFromPreset::class,
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
            SetModelProperty::class,
            SetDefinitionMethod::class,
        ];
    }
}
