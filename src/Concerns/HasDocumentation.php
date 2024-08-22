<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasDocumentation
{
    public function docs(string $description): static
    {
        data_set($this->attribute, 'docs.description', $description);

        return $this;
    }

    public function example(mixed $example): static
    {
        data_set($this->attribute, 'docs.example', $example);

        return $this;
    }
}
