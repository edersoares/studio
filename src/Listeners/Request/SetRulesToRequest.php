<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Request;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

/**
 * @codeCoverageIgnore
 */
class SetRulesToRequest
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $rules = collect($draft->get('attributes'))
            ->filter(fn ($attribute) => $attribute['validation']['rules'] ?? false)
            ->map(fn ($attribute) => $attribute['validation']['rules'])
            ->toArray();

        $generator->method('commonRules')
            ->setReturnType('array')
            ->setBody('return ?;', [$rules]);
    }
}
