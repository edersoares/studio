<?php

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasModelOptions
{
    public function fillable(bool $fillable = true): static
    {
        data_set($this->attribute, 'fillable', $fillable);

        return $this;
    }
}
