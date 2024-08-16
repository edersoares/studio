<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Nette\PhpGenerator\Closure;

class SetDownAlterTable
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        /** @var Closure $closure */
        $closure = $draft->get('migration:down');

        $content = $generator->printer()->printClosure($closure);

        $table = $draft->string('table', $draft->slug());

        $generator->method('down')
            ->setBody("Schema::table('$table', $content);");
    }
}
