<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Studio;

use Dex\Laravel\Studio\Art\Laravel\Model as Laravel;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\Model\SetFillableProperty;
use Dex\Laravel\Studio\Modifier\Model\SetTableProperty;

class Model extends Laravel
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            ...parent::apply(),
            SetTableProperty::class,
            SetFillableProperty::class,
        ];
    }
}
