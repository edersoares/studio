<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Concerns;

use Dex\Laravel\Studio\Attribute;

/**
 * @mixin Attribute
 */
trait HasValidationRules
{
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

    public function email(): static
    {
        return $this->rule('email');
    }

    public function confirmed(): static
    {
        return $this->rule('confirmed');
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
}
