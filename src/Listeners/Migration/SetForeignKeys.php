<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

class SetForeignKeys
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);

        $up = $generator->class()->addMethod('up')->setReturnType('void');

        $up->addBody('Schema::table(\'' . $draft->slug() . '\', function (Blueprint $table) {');

        $attributes = $draft->array('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] == 'foreign' && isset($attribute['foreign']))
            ->toArray();

        if (empty($columns)) {
            $generator->notGenerate();

            return;
        }

        foreach ($columns as $attribute => $options) {
            [$tableName, $columnName] = explode('.', $options['foreign']);

            $up->addBody('    $table->foreign(?)->on(?)->references(?);', [$attribute, $tableName, $columnName]);
        }

        $up->addBody('});');
    }
}
