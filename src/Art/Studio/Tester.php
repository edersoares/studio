<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Studio;

use Dex\Laravel\Studio\Art\Laravel\Model as Laravel;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\Tester\Tester as LaravelTester;

class Tester extends Laravel
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            LaravelTester::class,
        ];
    }
}
