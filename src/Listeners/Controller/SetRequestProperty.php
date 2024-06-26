<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Controller;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetRequestProperty
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var string $request */
        $request = $draft->get('model');
        $request = $preset->getNameFor('request', $request);

        if ($request) {
            $namespacedRequest = $preset->getNamespacedFor('request', $request);

            $generator->namespace()->addUse($namespacedRequest);

            $generator->class()
                ->addProperty('request')
                ->setProtected()
                ->setValue($request . '::class');
        }
    }
}
