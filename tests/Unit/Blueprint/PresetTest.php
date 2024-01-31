<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Preset;

test('expect `name` argument', function () {
    new Preset(['type' => 'model']);
})->expectExceptionMessage('Missing [name] key');

test('return `name`', function () {
    $preset = new Preset(['type' => 'model', 'name' => 'User']);

    expect($preset->name())->toBe('User');
});
