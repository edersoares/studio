<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

/**
 * @codeCoverageIgnore
 */
class SetFillableProperty
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $attributes = $draft->array('attributes');

        $fillable = array_filter($attributes, fn ($attribute) => $attribute['fillable'] ?? false);

        if ($fillable) {
            $generator->property('fillable')
                ->setProtected()
                ->setValue(array_keys($fillable));
        }
    }
}
