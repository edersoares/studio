<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Nette\PhpGenerator\Closure;

class SetUpClosure
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $closure = new Closure();
        $closure->addParameter('table')->setType('Blueprint');

        $draft->put('migration:up', $closure);
    }
}
