<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Nette\PhpGenerator\Closure;

class SetColumns
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $attributes = $draft->array('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] ?? false)
            ->toArray();

        if (empty($columns)) {
            return;
        }

        /** @var Closure $closure */
        $closure = $draft->get('create');

        foreach ($columns as $attribute => $options) {
            $allowed = [
                'id',
                'timestamps',
                'softDeletes',
            ];

            if (in_array($attribute, $allowed, true)) {
                $closure->addBody('$table->' . $attribute . '();');

                continue;
            }

            $type = $options['type'];

            $replaceable = [
                'foreign' => 'foreignId',
            ];

            if (isset($replaceable[$type])) {
                $type = $replaceable[$type];
            }

            $defaultValue = '';
            $nullable = '';
            $index = '';
            $extra = [$attribute];

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

            $closure->addBody('$table->' . $type . '(...?)' . $defaultValue . $nullable . $index . ';', [$extra]);
        }
    }
}
