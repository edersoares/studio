<?php

declare(strict_types=1);

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

    public function hidden(bool $hidden = true): static
    {
        data_set($this->attribute, 'hidden', $hidden);

        return $this;
    }

    public function cast(string $cast): static
    {
        data_set($this->attribute, 'cast', $cast);

        return $this;
    }
}
