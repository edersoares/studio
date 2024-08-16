<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Migration;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Schema\Blueprint as BlueprintAlias;
use Illuminate\Support\Facades\Schema;

/**
 * @codeCoverageIgnore
 */
class SetForeignKeys
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $generator->namespace()->addUse(BlueprintAlias::class);
        $generator->namespace()->addUse(Schema::class);

        $up = $draft->get('migration:up');

        $attributes = $draft->array('attributes');

        /** @var array $columns */
        $columns = collect($attributes)
            ->filter(fn ($attribute) => $attribute['type'] == 'foreignId' && isset($attribute['foreign']))
            ->toArray();

        if (empty($columns)) {
            $generator->notGenerate();

            return;
        }

        foreach ($columns as $attribute => $options) {
            [$tableName, $columnName] = explode('.', $options['foreign']);

            $up->addBody('$table->foreign(?)->on(?)->references(?);', [$attribute, $tableName, $columnName]);
        }
    }
}
