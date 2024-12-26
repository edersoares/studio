<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Space;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\NamespaceFromPreset;
use Dex\Laravel\Studio\Modifier\SetStrictTypesFromPreset;
use Dex\Laravel\Studio\Modifier\TraitsFromPreset;

class ControllerOrion extends Art
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            SetStrictTypesFromPreset::class,
            NamespaceFromPreset::class,
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
            TraitsFromPreset::class,
        ];
    }

    public function modify(Art $art): void
    {
        /** @var PhpGenerator $generator */
        $generator = $art->generator();

        $name = $art->draft()->name();
        $modelNamespaced = $art->preset()->getNamespacedFor('model', $name);
        $model = $art->preset()->getNameFor('model', $name);

        $art->generator()->namespace()->addUse($modelNamespaced);

        $generator->property('model')
            ->setProtected()
            ->setValue($model . '::class');
    }
}
