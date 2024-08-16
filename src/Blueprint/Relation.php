<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

/**
 * @codeCoverageIgnore
 */
class Relation
{
    private array $relation = [];

    public function __construct(
        private readonly Model $model
    ) {
    }

    public function belongsTo(string $method): static
    {
        data_set($this->relation, 'name', str($method)->slug()->value());
        data_set($this->relation, 'model', str($method)->studly()->value());
        data_set($this->relation, 'type', 'belongsTo');

        return $this;
    }

    public function hasMany(string $method): static
    {
        data_set($this->relation, 'name', str($method)->slug()->value());
        data_set($this->relation, 'model', str($method)->singular()->studly()->value());
        data_set($this->relation, 'type', 'hasMany');

        return $this;
    }

    public function name(): string
    {
        return $this->relation['name'];
    }

    public function value(): array
    {
        return $this->relation;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function attribute(): Attribute
    {
        return $this->model()->attribute();
    }

    public function relation(): self
    {
        return $this->model()->relation();
    }
}
