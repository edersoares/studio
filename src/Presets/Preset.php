<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Presets;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Preset extends Collection
{
    private Collection $dot;

    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    public function config(string $key)
    {
        if (empty($this->dot)) {
            $this->dot = new Collection(Arr::dot($this->all()));
        }

        return $this->dot->get($key);
    }
}
