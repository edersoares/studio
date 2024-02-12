<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

class SetColumns
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $attributes = $draft->array('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] ?? false)
            ->toArray();

        if (empty($columns)) {
            return;
        }

        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);

        $up = $generator->class()->addMethod('up')->setReturnType('void');

        $up->addBody('Schema::create(\'' . $draft->slug() . '\', function (Blueprint $table) {');

        foreach ($columns as $attribute => $options) {
            $allowed = [
                'id',
                'timestamps',
                'softDeletes',
            ];

            if (in_array($attribute, $allowed, true)) {
                $up->addBody('    $table->' . $attribute . '();');

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
                $defaultValue = '->default(' . $options['default'] . ')';
            }

            if ($options['nullable'] ?? false) {
                $nullable = '->nullable()';
            }

            if ($options['index'] ?? false) {
                $nullable = '->index()';
            }

            $up->addBody('    $table->' . $type . '(...?)' . $defaultValue . $nullable . $index . ';', [$extra]);
        }

        $up->addBody('});');
    }
}
