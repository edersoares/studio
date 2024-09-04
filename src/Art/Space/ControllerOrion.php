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
use Orion\Http\Requests\Request;

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
        ];
    }

    public function modify(Art $art): void
    {
        /** @var PhpGenerator $generator */
        $generator = $art->generator();

        $name = $art->draft()->name();
        $modelNamespaced = $art->preset()->getNamespacedFor('model', $name);
        $model = $art->preset()->getNameFor('model', $name);
        $requestNamespaced = Request::class;

        $generator->namespace()->addUse($requestNamespaced);

        $art->generator()->namespace()->addUse($modelNamespaced);

        $generator->method('index')
            ->setBody("return $model::query()->paginate();");

        $generator->method('store')
            ->addParameter('request')
            ->setType($requestNamespaced);
        $generator->method('store')
            ->addBody("return $model::query()->create(\$request->all());");

        $generator->method('show')
            ->addParameter('id')
            ->setType('string');
        $generator->method('show')
            ->setBody("return $model::query()->findOrFail(\$id);");

        $generator->method('update')
            ->addParameter('request')
            ->setType($requestNamespaced);
        $generator->method('update')
            ->addParameter('id')
            ->setType('string');
        $generator->method('update')
            ->addBody("\$model = $model::query()->findOrFail(\$id);")
            ->addBody('')
            ->addBody('$model->fill($request->all());')
            ->addBody('$model->save();')
            ->addBody('')
            ->addBody('return $model;');

        $generator->method('destroy')
            ->addParameter('id')
            ->setType('string');
        $generator->method('destroy')
            ->addBody("\$model = $model::query()->findOrFail(\$id);")
            ->addBody('')
            ->addBody('$model->delete();')
            ->addBody('')
            ->addBody('return $model;');
    }
}
