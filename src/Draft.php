<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

use Dex\Laravel\Studio\Support\Dotted;
use Dex\Laravel\Studio\Support\Typed;

class Draft
{
    use Dotted;
    use Typed;

    public function __construct(string $name)
    {
        $this->set('name', $name);
    }

    public function name(): string
    {
        return $this->string('name');
    }

    public function slug(): string
    {
        return $this->string('slug', str($this->name())->slug()->value());
    }

    public function type(): string
    {
        return $this->string('type');
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->get('attributes', []) as $name => $attribute) {
            if (is_array($attribute)) {
                $attributes[$name] = $attribute;
            } else {
                $attributes[$attribute->name()] = $attribute->data();
            }
        }

        return $attributes;
    }

    public function relations(): array
    {
        $relations = [];

        foreach ($this->get('relations', []) as $name => $relation) {
            if (is_array($relation)) {
                $relations[$name] = $relation;
            } else {
                $relations[$relation->name()] = $relation->data();
            }
        }

        return $relations;
    }

    public function data(): array
    {
        $draft = $this->all();

        if (isset($draft['attributes'])) {
            $draft['attributes'] = $this->attributes();
        }

        if (isset($draft['relations'])) {
            $draft['relations'] = $this->relations();
        }

        return $draft;
    }

    public function attribute(): Attribute
    {
        $attribute = new Attribute($this);

        $this->push('attributes', $attribute);

        return $attribute;
    }

    public function relation(): Relation
    {
        $relation = new Relation($this);

        $this->push('relations', $relation);

        return $relation;
    }

    public function art(string $type, string $preset): Art
    {
        $this->set('type', $type);
        $this->set('preset', $preset);

        $preseter = new Preset(['name' => $preset]);

        /** @var array $extends */
        $extends = config("studio.presets.$preset.extends", []);

        foreach ($extends as $extend) {
            /** @var array $config */
            $config = config("studio.presets.$extend", []);

            $preseter->setAll($config);
        }

        /** @var array $config */
        $config = config("studio.presets.$preset", []);

        $preseter->setAll($config);

        $art = $preseter->string("drafts.$type.use");

        return new $art($this, $preseter);
    }

    public static function new(string $name): self
    {
        return new self($name);
    }
}
