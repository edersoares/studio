<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use Dex\Laravel\Studio\Art;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UuidFromDraft
{
    public function modify(Art $art): void
    {
        foreach ($art->draft()->attributes() as $attribute) {
            if (empty($attribute['primary'])) {
                continue;
            }

            if ($attribute['type'] !== 'uuid') {
                continue;
            }

            $art->generator()
                ->namespace()
                ->addUse(HasUuids::class);

            $art->generator()
                ->class()
                ->addTrait(HasUuids::class);
        }
    }
}
