<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

use Dex\Laravel\Studio\Concerns\HasDraftItems;

class Relation
{
    use HasDraftItems;

    private array $relation = [];

    public function __construct(
        protected Draft $draft
    ) {}

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

    public function data(): array
    {
        return $this->relation;
    }
}
