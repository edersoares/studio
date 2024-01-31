<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;

test('expect `type` argument', function () {
    new Draft([]);
})->expectExceptionMessage('Missing [type] key');

test('expect `name` argument', function () {
    new Draft(['type' => 'model']);
})->expectExceptionMessage('Missing [name] key');
