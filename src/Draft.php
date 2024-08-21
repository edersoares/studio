<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

class Draft
{
    protected array $draft = [];
    protected array $attributes = [];

    public function __construct(string $name)
    {
        $this->draft['name'] = $name;
    }

    public function get(): array
    {
        $draft = $this->draft;

        if ($this->attributes) {
            $draft['attributes'] = [];

            foreach ($this->attributes as $attribute) {
                $draft['attributes'][$attribute->name()] = $attribute->get();
            }
        }

        return $draft;
    }

    public function attribute(): Attribute
    {
        $attribute = new Attribute($this);

        $this->attributes[] = $attribute;

        return $attribute;
    }

    public static function new(string $name): self
    {
        return new self($name);
    }
}
