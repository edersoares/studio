<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

/**
 * @codeCoverageIgnore
 */
class SetTableProperty
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        /** @var string $table */
        $table = $draft->get('table');

        if ($table) {
            $generator->property('table')
                ->setProtected()
                ->setValue($table);
        }
    }
}
