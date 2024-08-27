<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Migration;

use Dex\Laravel\Studio\Art;
use Nette\PhpGenerator\Closure;

class SetColumnsToCreate extends SetUpMethodToCreate
{
    protected function content(Art $art): ?string
    {
        $closure = new Closure();

        $closure->addParameter('table')->setType('Blueprint');

        $attributes = $art->draft()->attributes();

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] ?? false)
            ->toArray();

        foreach ($columns as $attribute => $options) {
            $allowed = [
                'id',
                'rememberToken',
                'timestamps',
                'softDeletes',
            ];

            $type = $options['type'];

            if (in_array($type, $allowed, true)) {
                $closure->addBody('$table->' . $attribute . '();');

                continue;
            }

            $primary = '';
            $defaultValue = '';
            $nullable = '';
            $index = '';
            $extra = [$attribute];

            if ($options['primary'] ?? false) {
                $primary = '->primary()';
            }

            if (isset($options['default'])) {
                if ($options['default'] === false) {
                    $options['default'] = 'false';
                }

                $defaultValue = '->default(' . $options['default'] . ')';
            }

            if ($options['nullable'] ?? false) {
                $nullable = '->nullable()';
            }

            if ($options['index'] ?? false) {
                $nullable = '->index()';
            }

            if ($options['unique'] ?? false) {
                $nullable = '->unique()';
            }

            $closure->addBody('$table->' . $type . '(...?)' . $primary . $defaultValue . $nullable . $index . ';', [$extra]);
        }

        return $art->generator()->printer()->printClosure($closure);
    }
}
