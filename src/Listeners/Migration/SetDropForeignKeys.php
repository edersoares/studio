<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

class SetDropForeignKeys
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);

        $down = $generator->class()->addMethod('down')->setReturnType('void');

        $down->addBody('Schema::table(\'' . $draft->slug() . '\', function (Blueprint $table) {');

        /** @var array $attributes */
        $attributes = $draft->get('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] == 'foreign' && isset($attribute['foreign']))
            ->toArray();

        if (empty($columns)) {
            $generator->notGenerate();

            return;
        }

        foreach ($columns as $attribute => $options) {
            $down->addBody('    $table->dropForeign([?]);', [$attribute]);
        }

        $down->addBody('});');
    }
}
