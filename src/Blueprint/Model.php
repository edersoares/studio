<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

class Model
{
    private array $attributes = [];

    private array $relations = [];

    public function __construct(
        private readonly string $name,
    ) {
    }

    public function attribute(): Attribute
    {
        $attribute = new Attribute($this);

        $this->attributes[] = $attribute;

        return $attribute;
    }

    public function relation(): Relation
    {
        $relation = new Relation($this);

        $this->relations[] = $relation;

        return $relation;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'type' => 'model',
            'model' => $this->name,
            'attributes' => collect($this->attributes)->mapWithKeys(fn (Attribute $attribute) => [
                $attribute->name() => $attribute->value(),
            ])->toArray(),
            'relations' => collect($this->relations)->mapWithKeys(fn (Relation $relation) => [
                $relation->name() => $relation->value(),
            ])->toArray(),
        ];
    }
}
