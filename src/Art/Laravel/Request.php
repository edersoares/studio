<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Laravel;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\NamespaceFromPreset;
use Dex\Laravel\Studio\Modifier\SetStrictTypesFromPreset;

class Request extends Art
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            SetStrictTypesFromPreset::class,
            NamespaceFromPreset::class,
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
        ];
    }

    public function modify(Art $art): void
    {
        $rules = collect($art->draft()->attributes())
            ->filter(fn ($attribute) => $attribute['validation']['rules'] ?? false)
            ->map(fn ($attribute) => $attribute['validation']['rules'])
            ->toArray();

        $art->generator()->method('rules')
            ->setReturnType('array')
            ->setBody('return ?;', [$rules]);
    }
}
