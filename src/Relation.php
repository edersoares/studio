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

    public function belongsTo(string $model, ?string $method = null): static
    {
        $method ??= str($model)->camel()->value();

        data_set($this->relation, 'name', $method);
        data_set($this->relation, 'model', $model);
        data_set($this->relation, 'type', 'belongsTo');

        return $this;
    }

    public function hasMany(string $model, ?string $method = null): static
    {
        $method ??= str($model)->plural()->camel()->value();

        data_set($this->relation, 'name', $method);
        data_set($this->relation, 'model', $model);
        data_set($this->relation, 'type', 'hasMany');

        return $this;
    }

    public function hasOne(string $model, ?string $method = null): static
    {
        $method ??= str($model)->camel()->value();

        data_set($this->relation, 'name', $method);
        data_set($this->relation, 'model', $model);
        data_set($this->relation, 'type', 'hasOne');

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
