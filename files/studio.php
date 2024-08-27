<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

function draft(string $name): Draft
{
    return Draft::new($name);
}
