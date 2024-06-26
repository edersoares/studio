<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Controller;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetModelProperty
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var string $model */
        $model = $draft->get('model');

        if ($model) {
            $namespacedModel = $preset->getNamespacedFor('model', $model);

            $generator->namespace()->addUse($namespacedModel);

            $generator->class()
                ->addProperty('model')
                ->setProtected()
                ->setValue($model . '::class');
        }
    }
}
