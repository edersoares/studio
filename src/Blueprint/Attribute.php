<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

class Attribute
{
    private array $attribute = [];

    public function __construct(
        private readonly Model $model
    ) {
    }

    public function id(): static
    {
        data_set($this->attribute, 'name', 'id');
        data_set($this->attribute, 'type', 'id');

        return $this;
    }

    public function foreign(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'foreignId');
        data_set($this->attribute, 'foreign', str($name)->replaceLast('_id', '.id')->value());

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

    public function string(string $name): static
    {
        data_set($this->attribute, 'name', $name);
        data_set($this->attribute, 'type', 'string');

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

    public function fillable(bool $fillable = true): static
    {
        data_set($this->attribute, 'fillable', $fillable);

        return $this;
    }

    public function nullable(bool $nullable = true): static
    {
        data_set($this->attribute, 'nullable', $nullable);

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

    public function factory(string $model): static
    {
        data_set($this->attribute, 'factory.model', [$model]);

        return $this;
    }

    public function faker(...$args): static
    {
        data_set($this->attribute, 'factory.faker', $args);

        return $this;
    }

    public function docs(string $description): static
    {
        data_set($this->attribute, 'docs.description', $description);

        return $this;
    }

    public function example(string|int $example): static
    {
        data_set($this->attribute, 'docs.example', $example);

        return $this;
    }

    private function rule(string $rule): static
    {
        /** @var array $rules */
        $rules = data_get($this->attribute, 'validation.rules', []);

        $rules[] = $rule;

        data_set($this->attribute, 'validation.rules', $rules);

        return $this;
    }

    public function required(): static
    {
        return $this->rule('required');
    }

    public function min(int $min): static
    {
        return $this->rule("min:$min");
    }

    public function max(int $max): static
    {
        return $this->rule("max:$max");
    }

    public function size(int $length): static
    {
        return $this->rule("size:$length");
    }

    public function name(): string
    {
        return $this->attribute['name'];
    }

    public function value(): array
    {
        return $this->attribute;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function attribute(): self
    {
        return $this->model()->attribute();
    }

    public function relation(): Relation
    {
        return $this->model()->relation();
    }
}
