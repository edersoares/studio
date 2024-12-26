<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasOrionOptions
{
    public function filterable(): static
    {
        data_set($this->attribute, 'orion.is_filterable', true);

        return $this;
    }

    public function searchable(): static
    {
        data_set($this->attribute, 'orion.is_searchable', true);

        return $this;
    }

    public function sortable(): static
    {
        data_set($this->attribute, 'orion.is_sortable', true);

        return $this;
    }

    public function includable(): static
    {
        data_set($this->attribute, 'orion.is_includable', true);

        return $this;
    }

    public function isRelation(): static
    {
        data_set($this->attribute, 'orion.is_relation', true);

        return $this;
    }
}
