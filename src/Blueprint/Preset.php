<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Blueprint;

use Dex\Laravel\Studio\Support\DottedGetter;
use Dex\Laravel\Studio\Support\TypedGetter;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * @extends Collection<string, mixed>
 */
class Preset extends Collection
{
    use DottedGetter;
    use TypedGetter;

    public function __construct($items = [])
    {
        parent::__construct($items);

        if ($this->has('name') === false) {
            throw new InvalidArgumentException('Missing [name] key');
        }
    }

    public function name(): string
    {
        return $this->string('name');
    }

    public function trim(string $string, string $word): string
    {
        if (strlen($word) === 0) {
            return $string;
        }

        if (str_starts_with($string, $word)) {
            $string = substr($string, strlen($word));
        }

        if (str_ends_with($string, $word)) {
            $string = substr($string, 0, -strlen($word));
        }

        return $string;
    }

    public function getModelNameFor(string $type, string $name): string
    {
        $name = $this->trim($name, $this->dotted("drafts.$type.prefix", ''));

        return $this->trim($name, $this->dotted("drafts.$type.suffix", ''));
    }

    public function getNameFor(string $type, string $name): string
    {
        $name = $this->getModelNameFor($type, $name);

        return $this->dotted("drafts.$type.prefix") . $name . $this->dotted("drafts.$type.suffix");
    }

    public function getNamespaceForType(string $type): string
    {
        $kind = $this->dotted("drafts.$type.kind", 'source');
        $baseNamespace = $this->dotted('namespace', '');
        $kindNamespace = $this->dotted("namespaces.$kind", '');
        $namespace = $this->dotted("drafts.$type.namespace", '');

        return $this->joinNamespaces([
            $baseNamespace,
            $kindNamespace,
            $namespace,
        ]);
    }

    public function getNamespacedFor(string $type, string $name): string
    {
        return $this->joinNamespaces([
            $this->getNamespaceForType($type),
            $this->getNameFor($type, $name),
        ]);
    }

    public function getFilenameFor(string $type, string $name): string
    {
        $kind = $this->dotted("drafts.$type.kind", 'source');
        $basePath = $this->dotted('path');
        $kindPath = $this->dotted("paths.$kind", '');
        $path = $this->dotted("drafts.$type.path", '');
        $filename = $this->dotted("drafts.$type.filename") ?? function ($type, $name, $preset) {
            return $preset->getNameFor("drafts.$type", $name);
        };
        $extension = $this->dotted("drafts.$type.extension", '.php');

        $file = $filename($type, $name, $this);

        return $this->joinPaths([
            $basePath,
            $kindPath,
            $path,
            $file . $extension,
        ]);
    }

    private function joinPaths(array $paths): string
    {
        $paths = array_filter($paths, fn ($path) => $path);
        $paths = array_map(fn ($path) => rtrim($path, DIRECTORY_SEPARATOR), $paths);

        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    private function joinNamespaces(array $namespaces): string
    {
        $namespaces = array_filter($namespaces, fn ($namespace) => $namespace);
        $namespaces = array_map(fn ($namespace) => trim($namespace, '\\'), $namespaces);

        return implode('\\', $namespaces);
    }
}
