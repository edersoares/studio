<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Http\Controllers;

class StudioController
{
    public function __invoke(): string
    {
        return 'Studio for Artisans';
    }
}
