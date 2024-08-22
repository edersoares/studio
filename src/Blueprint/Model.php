<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

/**
 * @codeCoverageIgnore
 */
class Model
{
    private array $attributes = [];

    private array $relations = [];

    private array $generate = [];

    public function __construct(
        private readonly string $name,
    ) {}

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

    public function generate(string $type): self
    {
        if (in_array($type, $this->generate, true) === false) {
            $this->generate[] = $type;
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => 'model',
            'name' => $this->name,
            'model' => $this->name,
            'table' => str($this->name)->snake()->slug('_')->value(),
            'endpoint' => str($this->name)->snake()->slug()->value(),
            'attributes' => collect($this->attributes)->mapWithKeys(fn (Attribute $attribute) => [
                $attribute->name() => $attribute->value(),
            ])->toArray(),
            'relations' => collect($this->relations)->mapWithKeys(fn (Relation $relation) => [
                $relation->name() => $relation->value(),
            ])->toArray(),
            'generate' => $this->generate,
        ];
    }

    public function art(string $type, ?string $preset = null): Art
    {
        $preset ??= config('studio.preset');

        return Factory::art($this->name(), $type, $preset, $this->toArray());
    }
}
