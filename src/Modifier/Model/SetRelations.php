<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Art;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SetRelations
{
    public function modify(Art $art): void
    {
        $relations = $art->draft()->relations();
        $generator = $art->generator();

        foreach ($relations as $name => $relation) {
            $relationModel = $relation['model'];
            $method = $generator->method($name);
            $namespacedModel = $art->preset()->getNamespacedFor('model', $relationModel);

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
