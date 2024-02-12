<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
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

    protected Draft $draft;

    protected Blueprint $blueprint;

    protected Preset $preset;

    protected bool $shouldGenerate = true;

    protected string $body;

    public function __construct(Draft $draft, Blueprint $blueprint, Preset $preset)
    {
        $this->file = new PhpFile();
        $this->draft = $draft;
        $this->blueprint = $blueprint;
        $this->preset = $preset;
    }

    public function printer(): Printer
    {
        return new class extends Printer {
            public bool $omitEmptyNamespaces = false;

            public int $linesBetweenProperties = 1;

            public int $linesBetweenMethods = 1;

            public string $indentation = '    ';

            protected function dump(mixed $var, int $column = 0): string
            {
                if (is_string($var) && str_ends_with($var, '::class')) {
                    return $var;
                }

                return parent::dump($var, $column);
            }
        };
    }

    public function notGenerate(): void
    {
        $this->shouldGenerate = false;
    }

    public function shouldGenerate(): bool
    {
        return $this->shouldGenerate;
    }

    public function generate(): string
    {
        $body = '';

        if (isset($this->body)) {
            $body = $this->body;
        }

        return $this->printer()->printFile($this->file) . $body;
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

    public function body(string $body): void
    {
        $this->body = $body;
    }
}
