<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Art;

/**
 * @mixin Art
 */
trait GeneratePhp
{
    protected PhpGenerator $generator;

    public function generator(): PhpGenerator
    {
        if (empty($this->generator)) {
            $this->generator = new PhpGenerator($this->draft(), $this->preset());
        }

        return $this->generator;
    }
}
