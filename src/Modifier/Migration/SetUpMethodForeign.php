<?php

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Blueprint\Art;
use Nette\PhpGenerator\Closure;

class SetUpMethodForeign extends SetUpMethodToCreate
{
    protected function action(Art $art): string
    {
        return 'table';
    }

    protected function content(Art $art): ?string
    {
        $closure = new Closure();

        $closure->addParameter('table')->setType('Blueprint');

        $attributes = $art->draft()->array('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] == 'foreignId' && isset($attribute['foreign']))
            ->toArray();

        if (empty($columns)) {
            $art->generator()->notGenerate();
        }

        foreach ($columns as $attribute => $options) {
            [$tableName, $columnName] = explode('.', $options['foreign']);

            $closure->addBody('$table->foreign(?)->on(?)->references(?);', [$attribute, $tableName, $columnName]);
        }

        return $art->generator()->printer()->printClosure($closure);
    }
}
