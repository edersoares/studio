<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;
use Dex\Laravel\Studio\Draft;
use Dex\Laravel\Studio\Relation;

trait HasDraftItems
{
    protected Draft $draft;

    public function draft(): Draft
    {
        return $this->draft;
    }

    public function attribute(): Attribute
    {
        return $this->draft->attribute();
    }

    public function relation(): Relation
    {
        return $this->draft->relation();
    }
}
