<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;

test('expect `type` argument', function () {
    new Draft([]);
})->expectExceptionMessage('Missing [type] key');

test('expect `name` argument', function () {
    new Draft(['type' => 'model']);
})->expectExceptionMessage('Missing [name] key');

test('expect `slug` argument', function () {
    new Draft(['type' => 'model', 'name' => 'User']);
})->expectExceptionMessage('Missing [slug] key');

test('`slug` method', function () {
    $draft = new Draft(['type' => 'model', 'name' => 'User', 'slug' => 'user']);

    expect($draft->slug())->toBe('user');
});
