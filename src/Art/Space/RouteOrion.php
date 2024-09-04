<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Space;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Orion\Facades\Orion;

class RouteOrion extends Art
{
    use GeneratePhp;

    protected static array $body = [];

    public function modify(Art $art): void
    {
        /** @var PhpGenerator $generator */
        $generator = $art->generator();

        $name = $art->draft()->name();
        $endpoint = $art->draft()->string('endpoint');
        $controller = $art->preset()->getNameFor('controller', $name);
        $namespacedController = $art->preset()->getNamespacedFor('controller', $name);

        $generator->file()->setStrictTypes();
        $generator->namespace()->addUse(Orion::class);
        $generator->namespace()->addUse($namespacedController);

        static::$body[] = "Orion::resource('$endpoint', $controller::class);";

        sort(static::$body, SORT_STRING);

        $generator->body(implode("\n", static::$body) . "\n");
    }
}
