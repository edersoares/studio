<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetFactory
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $name = $preset->getModelNameFor('eloquent', $draft->name());
        $factory = $preset->getNamespacedFor('factory', $name);
        $factoryName = $preset->getNameFor('factory', $name);

        $generator->namespace()->addUse($factory);
        $generator->namespace()->addUse(HasFactory::class);

        $generator->trait(HasFactory::class)
            ->addComment("@use HasFactory<$factoryName>");

        $generator->property('factory')
            ->setValue($factoryName . '::class')
            ->setType('string')
            ->setProtected()
            ->setStatic();
    }
}
