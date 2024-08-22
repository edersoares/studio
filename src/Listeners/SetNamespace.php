<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetNamespace
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $namespace = $preset->getNamespaceForType($draft->type());

        if ($namespace) {
            $generator->namespace($namespace);
        }
    }
}
