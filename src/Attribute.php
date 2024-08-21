<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

use Dex\Laravel\Studio\Concerns\HasDatabaseColumns;
use Dex\Laravel\Studio\Concerns\HasDatabaseOptions;
use Dex\Laravel\Studio\Concerns\HasFactoryOptions;
use Dex\Laravel\Studio\Concerns\HasModelOptions;
use Dex\Laravel\Studio\Concerns\HasValidationRules;

class Attribute
{
    use HasDatabaseColumns;
    use HasDatabaseOptions;
    use HasFactoryOptions;
    use HasModelOptions;
    use HasValidationRules;

    protected array $attribute = [];

    public function __construct(
        protected Draft $draft
    ) {}

    public function get(): array
    {
        return $this->attribute;
    }

    public function name(): string
    {
        return $this->attribute['name'];
    }

    public function draft(): Draft
    {
        return $this->draft;
    }

    public function attribute(): Attribute
    {
        return $this->draft->attribute();
    }
}
