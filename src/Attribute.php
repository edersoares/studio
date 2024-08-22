<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio;

use Dex\Laravel\Studio\Concerns\HasDatabaseColumns;
use Dex\Laravel\Studio\Concerns\HasDatabaseOptions;
use Dex\Laravel\Studio\Concerns\HasDocumentation;
use Dex\Laravel\Studio\Concerns\HasDraftItems;
use Dex\Laravel\Studio\Concerns\HasFactoryOptions;
use Dex\Laravel\Studio\Concerns\HasModelOptions;
use Dex\Laravel\Studio\Concerns\HasValidationRules;

class Attribute
{
    use HasDatabaseColumns;
    use HasDatabaseOptions;
    use HasDocumentation;
    use HasDraftItems;
    use HasFactoryOptions;
    use HasModelOptions;
    use HasValidationRules;

    protected array $attribute = [];

    public function __construct(
        protected Draft $draft
    ) {}

    public function data(): array
    {
        return $this->attribute;
    }

    public function name(): string
    {
        return $this->attribute['name'];
    }
}
