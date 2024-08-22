<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

use Dex\Laravel\Studio\Support\Dotted;
use Dex\Laravel\Studio\Support\Typed;

class Preset
{
    use Dotted;
    use Typed;

    public function __construct(array $preset)
    {
        $this->dotted = $preset;
    }

    public function name(): string
    {
        return $this->string('name'); // @codeCoverageIgnore
    }

    public function trim(string $string, string $word): string
    {
        if (strlen($word) === 0) {
            return $string;
        }

        if (str_starts_with($string, $word)) {
            $string = substr($string, strlen($word)); // @codeCoverageIgnore
        }

        if (str_ends_with($string, $word)) {
            $string = substr($string, 0, -strlen($word)); // @codeCoverageIgnore
        }

        return $string;
    }

    public function getModelNameFor(string $type, string $name): string
    {
        /** @var string $prefix */
        $prefix = $this->get("drafts.$type.prefix", '');

        /** @var string $suffix */
        $suffix = $this->get("drafts.$type.suffix", '');

        $name = $this->trim($name, $prefix);

        return $this->trim($name, $suffix);
    }

    public function getNameFor(string $type, string $name): string
    {
        $name = $this->getModelNameFor($type, $name);

        return $this->get("drafts.$type.prefix") . $name . $this->get("drafts.$type.suffix");
    }

    public function getNamespaceForType(string $type): string
    {
        /** @var string $kind */
        $kind = $this->get("drafts.$type.kind", 'source');
        $baseNamespace = $this->get('namespace', '');
        $kindNamespace = $this->get("namespaces.$kind", '');
        $namespace = $this->get("drafts.$type.namespace", '');

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
        $kind = $this->string("drafts.$type.kind", 'source');
        $basePath = $this->get('path');
        $kindPath = $this->get("paths.$kind", '');
        $path = $this->get("drafts.$type.path", '');
        /** @var callable $filename */
        $filename = $this->get("drafts.$type.filename") ?? function ($type, $name, $preset) {
            return $preset->getNameFor($type, $name);
        };
        $extension = $this->get("drafts.$type.extension", '.php');

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
