<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

use Illuminate\Support\Arr;

trait Dotted
{
    protected array $dotted = [];

    public function all(): array
    {
        return $this->dotted;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->dotted, $key, $default);
    }

    public function set(string $key, mixed $default): self
    {
        data_set($this->dotted, $key, $default);

        return $this;
    }

    public function push(string $key, mixed $value): self
    {
        $data = $this->get($key, []);

        return $this->set($key, array_merge($data, [$value]));
    }

    public function setAll(array $data): self
    {
        $dot = Arr::dot($data);

        foreach ($dot as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }
}
