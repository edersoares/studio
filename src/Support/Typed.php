<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Support;

trait Typed
{
    use Dotted;

    public function array(string $key, array $default = []): array
    {
        return (array) $this->get($key, $default);
    }

    public function string(string $key, string $default = ''): string
    {
        return (string) $this->get($key, $default);
    }

    public function stringOrNull(string $key, ?string $default = null): ?string
    {
        if ($value = $this->get($key, $default)) {
            return $value;
        }

        return $default;
    }

    public function integer(string $key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }

    public function boolean(string $key, bool $default = false): bool
    {
        return (bool) $this->get($key, $default);
    }

    public function callable(string $key, ?callable $default = null): callable
    {
        return $this->get($key, $default) ?? function () {};
    }
}
