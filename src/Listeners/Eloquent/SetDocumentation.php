<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use DateTime;
use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Eloquent\Collection;

class SetDocumentation
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $attributes = $draft->array('attributes');

        foreach ($attributes as $attribute => $options) {
            $type = $options['type'];

            if (in_array($type, ['id', 'foreign'])) {
                $type = 'int';
            }

            if ($type === 'timestamps') {
                $generator->namespace()->addUse(DateTime::class);
                $generator->class()->addComment("@property DateTime \$created_at");
                $generator->class()->addComment("@property DateTime \$updated_at");

                continue;
            }

            if ($type === 'softDeletes') {
                $generator->namespace()->addUse(DateTime::class);
                $generator->class()->addComment("@property DateTime \$deleted_at");

                continue;
            }

            $generator->class()->addComment("@property $type \$$attribute");
        }

        $relations = $draft->array('relations');

        foreach ($relations as $relation => $options) {
            $type = $options['type'];

            $model = $preset->getNameFor('model', $options['model']);
            $namespacedModel = $preset->getNamespacedFor('model', $options['model']);

            if ($type === 'belongsTo') {
                $generator->namespace()->addUse($namespacedModel);
                $generator->class()->addComment("@property $model \$$relation");
            }

            if ($type === 'hasMany') {
                $generator->namespace()->addUse(Collection::class);
                $generator->namespace()->addUse($namespacedModel);
                $generator->class()->addComment("@property Collection<int, $model> \$$relation");
            }
        }

        $generator->class()->addComment('');
    }
}
