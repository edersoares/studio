<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetMethods
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var array $methods */
        $methods = $preset->dotted("{$draft->type()}.methods", []);

        foreach ($methods as $method) {
            $newMethod = $generator->class()->addMethod($method['name']);

            if (array_key_exists('return', $method)) {
                $newMethod->setReturnType($method['return']);
            }

            if (array_key_exists('body', $method)) {
                $newMethod->setBody($method['body']);
            }
        }
    }
}
