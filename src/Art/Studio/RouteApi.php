<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Studio;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Support\Facades\Route;

class RouteApi extends Art
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
        $generator->namespace()->addUse(Route::class);
        $generator->namespace()->addUse($namespacedController);

        static::$body[] = "Route::apiResource('$endpoint', $controller::class);";

        sort(static::$body, SORT_STRING);

        $generator->body(implode("\n", static::$body) . "\n");
    }
}
