<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Model;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

/**
 * @codeCoverageIgnore
 */
class SetCustomEloquent
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $extends = $preset->getNamespacedFor('eloquent', $draft->string('name'));

        $generator->namespace()->addUse($extends, 'Eloquent');
        $generator->class()->setExtends($extends);
    }
}
