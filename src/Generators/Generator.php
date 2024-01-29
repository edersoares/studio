<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;

class Generator
{
    /**
     * @var Collection<string, mixed>
     */
    protected Collection $config;

    protected PhpFile $file;

    protected PhpNamespace $namespace;

    protected ClassType $class;

    public function __construct(Collection $config)
    {
        $this->file = new PhpFile();
        $this->config = $config;
    }

    public function config(string $key)
    {
        return $this->config->get($key);
    }

    public function string(string $key): string
    {
        return $this->config($key);
    }

    public function printer(): Printer
    {
        return new Printer();
    }

    public function generate(): string
    {
        return $this->printer()->printFile($this->file);
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
