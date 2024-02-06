<?php

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

class SetDropTableMethod
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);

        $generator->class()->addMethod('down')
            ->setReturnType('void')
            ->addBody('Schema::dropIfExists(\'' . $draft->slug() . '\');');
    }
}
