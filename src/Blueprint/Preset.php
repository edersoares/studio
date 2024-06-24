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

    public function getNamespacedFor(string $type, string $name): string
    {
        return $this->dotted("drafts.$type.namespace") . '\\' . $this->getNameFor($type, $name);
    }

    public function getFilenameFor(string $type, string $name): string
    {
        $filename = $this->dotted("drafts.$type.filename");

        if (is_callable($filename)) {
            return $filename($type, $name, $this);
        }

        $path = $this->dotted("drafts.$type.path");
        $file = $this->getNameFor("drafts.$type", $name);
        $extension = $this->dotted("drafts.$type.extension");

        return $path . DIRECTORY_SEPARATOR . $file . $extension;
    }
}
