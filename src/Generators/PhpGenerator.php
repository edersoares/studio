<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Generators;

use Dex\Laravel\Studio\Draft;
use Dex\Laravel\Studio\Preset;
use Illuminate\Support\Collection;
use Nette\InvalidArgumentException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\Property;
use Nette\PhpGenerator\TraitUse;

class PhpGenerator extends Generator
{
    /**
     * @var Collection<string, string>
     */
    protected Collection $config;

    protected PhpFile $file;

    protected PhpNamespace $namespace;

    protected ClassType $class;

    protected string $body;

    public function __construct(Draft $draft, Preset $preset)
    {
        parent::__construct($draft, $preset);

        if (file_exists($this->filename()) && $preset->boolean('reuse')) {
            $this->file = PhpFile::fromCode(file_get_contents($this->filename())); // @codeCoverageIgnore
        } else {
            $this->file = new PhpFile();
        }
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

                return parent::dump($var, $column); // @codeCoverageIgnore
            }
        };
    }

    public function generate(): string
    {
        $body = '';

        if (isset($this->body)) {
            $body = $this->body; // @codeCoverageIgnore
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
        try {
            $this->class = $this->namespace()->getClass($class);
        } catch (InvalidArgumentException) {
            if (empty($this->class) || $class) {
                $this->class = $this->namespace()->addClass($class);
            }
        }

        return $this->class;
    }

    /**
     * @codeCoverageIgnore
     */
    public function extends(string $class): ClassType
    {
        return $this->class()->setExtends($class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function implements(string $class): ClassType
    {
        return $this->class()->addImplement($class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function trait(string $trait): TraitUse
    {
        $this->class()->removeTrait($trait);

        return $this->class()->addTrait($trait);
    }

    /**
     * @codeCoverageIgnore
     */
    public function property(string $property): Property
    {
        return $this->class()->hasProperty($property)
            ? $this->class()->getProperty($property)
            : $this->class()->addProperty($property);
    }

    /**
     * @codeCoverageIgnore
     */
    public function method(string $method): Method
    {
        return $this->class()->hasMethod($method)
            ? $this->class()->getMethod($method)
            : $this->class()->addMethod($method);
    }

    /**
     * @codeCoverageIgnore
     */
    public function body(string $body): void
    {
        $this->body = $body;
    }
}
