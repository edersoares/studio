<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasFactoryOptions
{
    public function factory(string $model): static
    {
        data_set($this->attribute, 'factory.model', [$model]);

        return $this;
    }

    public function faker(mixed ...$args): static
    {
        data_set($this->attribute, 'factory.faker', $args);

        return $this;
    }
}
