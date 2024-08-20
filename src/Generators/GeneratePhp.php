<?php

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Blueprint\Art;
use Dex\Laravel\Studio\Blueprint\Blueprint;

/**
 * @mixin Art
 */
trait GeneratePhp
{
    protected PhpGenerator $generator;

    public function generator(): PhpGenerator
    {
        if (empty($this->generator)) {
            $this->generator = new PhpGenerator($this->draft(), new Blueprint(), $this->preset());
        }

        return $this->generator;
    }
}
