<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Nette\PhpGenerator\Closure;

class SetUpAlterTable
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        /** @var Closure $closure */
        $closure = $draft->get('migration:up');

        $content = $generator->printer()->printClosure($closure);

        $table = $draft->string('table', $draft->slug());

        $generator->method('up')
            ->setBody("Schema::table('$table', $content);");
    }
}
