<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Factory;

use Dex\Laravel\Studio\Blueprint\Art;

class SetModelProperty
{
    public function modify(Art $art): void
    {
        $name = $art->preset()->trim($art->draft()->name(), 'Factory');

        $modelNamespaced = $art->preset()->getNamespacedFor('model', $name);
        $model = $art->preset()->getNameFor('model', $name);

        $art->generator()->namespace()->addUse($modelNamespaced);

        $art->generator()->property('model')
            ->setProtected()
            ->setValue($model . '::class');
    }
}
