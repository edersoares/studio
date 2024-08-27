<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasDatabaseColumns
{
    public function id(): static
    {
        data_set($this->attribute, 'name', 'id');
        data_set($this->attribute, 'type', 'id');

        return $this;
    }

    public function uuid($name = 'uuid'): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'uuid');

        return $this;
    }

    public function foreign(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'foreignId');
        data_set($this->attribute, 'foreign', str($name)->replaceLast('_id', '.id')->value());

        return $this;
    }

    public function string(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'string');

        return $this;
    }

    public function text(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'text');

        return $this;
    }

    public function longText(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'longText');

        return $this;
    }

    public function integer(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'integer');

        return $this;
    }

    public function float(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'float');

        return $this;
    }

    public function boolean(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'boolean');

        return $this;
    }

    public function rememberToken(): static
    {
        data_set($this->attribute, 'name', 'rememberToken');
        data_set($this->attribute, 'type', 'rememberToken');

        return $this;
    }

    public function timestamp(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'timestamp');

        return $this;
    }

    public function timestamps(): static
    {
        data_set($this->attribute, 'name', 'timestamps');
        data_set($this->attribute, 'type', 'timestamps');

        return $this;
    }

    public function softDeletes(): static
    {
        data_set($this->attribute, 'name', 'softDeletes');
        data_set($this->attribute, 'type', 'softDeletes');

        return $this;
    }
}
