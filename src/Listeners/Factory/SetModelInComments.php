<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetModelInComments
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $model = $preset->trim($draft->name(), 'Factory');

        $class = $preset->getNameFor('model', $model);
        $namespacedClass = $preset->getNamespacedFor('model', $model);

        $comment = "@extends Factory<$class>";

        if (str_contains((string) $generator->class()->getComment(), $comment)) {
            return; // @codeCoverageIgnore
        }

        $generator->namespace()->addUse($namespacedClass);
        $generator->class()->addComment($comment);
    }
}
