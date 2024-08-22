<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @codeCoverageIgnore
 */
class SetRelations
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $relations = $draft->array('relations');

        foreach ($relations as $name => $relation) {
            $relationModel = $relation['model'];
            $method = $generator->method($name);
            $namespacedModel = $preset->getNamespacedFor('model', $relationModel);

            if ($relation['type'] === 'belongsTo') {
                $generator->namespace()->addUse(BelongsTo::class);
                $generator->namespace()->addUse($namespacedModel);
                $method->setComment("@return BelongsTo<$relationModel, self>");
                $method->setReturnType(BelongsTo::class);
                $method->setBody('return $this->belongsTo(' . $relationModel . '::class);');
            }

            if ($relation['type'] === 'hasMany') {
                $generator->namespace()->addUse(HasMany::class);
                $generator->namespace()->addUse($namespacedModel);
                $method->setComment("@return HasMany<$relationModel>");
                $method->setReturnType(HasMany::class);
                $method->setBody('return $this->hasMany(' . $relationModel . '::class);');
            }
        }
    }
}
