<?php

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasDatabaseOptions
{
    public function primary(bool $primary = true): static
    {
        data_set($this->attribute, 'primary', $primary);

        return $this;
    }

    public function unique(bool $unique = true): static
    {
        data_set($this->attribute, 'unique', $unique);

        return $this;
    }

    public function index(bool $index = true): static
    {
        data_set($this->attribute, 'index', $index);

        return $this;
    }

    public function nullable(bool $nullable = true): static
    {
        data_set($this->attribute, 'nullable', $nullable);

        return $this;
    }

    public function default(mixed $value): static
    {
        data_set($this->attribute, 'default', $value);

        return $this;
    }
}
