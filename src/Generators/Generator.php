<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Blueprint\Preset;
use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;

class Generator
{
    /**
     * @var Collection<string, string>
     */
    protected Collection $config;

    protected PhpFile $file;

    protected PhpNamespace $namespace;

    protected ClassType $class;

    protected Preset $preset;

    protected string $type;

    protected string $name;

    public function __construct(string $type, string $name, Preset $preset)
    {
        $this->file = new PhpFile();
        $this->type = $type;
        $this->name = $name;
        $this->preset = $preset;
    }

    public function config(string $key): mixed
    {
        return $this->preset->config($key);
    }

    public function printer(): Printer
    {
        return new class extends Printer {
            public bool $omitEmptyNamespaces = false;

            public int $linesBetweenProperties = 1;

            public int $linesBetweenMethods = 1;

            public string $indentation = '    ';
        };
    }

    public function generate(): string
    {
        return $this->printer()->printFile($this->file);
    }

    public function preset(): Preset
    {
        return $this->preset;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function file(): PhpFile
    {
        return $this->file;
    }

    public function namespace(string $namespace = ''): PhpNamespace
    {
        if (empty($this->namespace) || $namespace) {
            $this->namespace = $this->file()->addNamespace($namespace);
        }

        return $this->namespace;
    }

    public function class(string $class = ''): ClassType
    {
        if (empty($this->class) || $class) {
            $this->class = $this->namespace()->addClass($class);
        }

        return $this->class;
    }
}
