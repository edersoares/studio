<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Art;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nette\PhpGenerator\Closure;

abstract class AlterMigration
{
    abstract protected function method(Art $art): string;

    abstract protected function action(Art $art): string;

    protected function content(Art $art): ?string
    {
        $closure = new Closure();

        $closure->addParameter('table')->setType('Blueprint');

        return $art->generator()->printer()->printClosure($closure);
    }

    public function modify(Art $art): void
    {
        $method = $this->method($art);
        $action = $this->action($art);
        $content = $this->content($art);

        if ($content) {
            $content = ", $content";
        }

        $table = $art->draft()->string('table', str($art->draft()->slug())->slug('_')->value());

        $art->generator()->namespace()->addUse(Blueprint::class);
        $art->generator()->namespace()->addUse(Schema::class);
        $art->generator()->method($method)->setReturnType('void')->setBody("Schema::$action('$table'$content);");
    }
}
