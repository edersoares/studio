<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

class SetUpMethod
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);
        $generator->method('up')->setReturnType('void');
    }
}
