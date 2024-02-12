<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SetRelations
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $relations = $draft->array('relations');

        foreach ($relations as $name => $relation) {
            $model = $relation['model'];
            $method = $generator->class()->addMethod($name);
            $namespacedModel = $preset->getNamespacedFor('model', $model);

            if ($relation['type'] === 'belongsTo') {
                $generator->namespace()->addUse(BelongsTo::class);
                $generator->namespace()->addUse($namespacedModel);
                $method->setReturnType(BelongsTo::class);
                $method->setBody('return $this->belongsTo(' . $model . '::class);');
            }

            if ($relation['type'] === 'hasMany') {
                $generator->namespace()->addUse(HasMany::class);
                $generator->namespace()->addUse($namespacedModel);
                $method->setReturnType(HasMany::class);
                $method->setBody('return $this->hasMany(' . $model . '::class);');
            }
        }
    }
}
