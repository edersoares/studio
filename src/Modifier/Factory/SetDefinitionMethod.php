<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Factory;

use Dex\Laravel\Studio\Blueprint\Art;

/**
 * @codeCoverageIgnore
 */
class SetDefinitionMethod
{
    public function modify(Art $art): void
    {
        $art->generator()
            ->method('definition')
            ->setReturnType('array')
            ->setBody('')
            ->addBody('return [')
            ->addBody('];');
    }
}
