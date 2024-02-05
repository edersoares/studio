<?php

declare(strict_types=1);

test('`blueprint` command exists')
    ->artisan('blueprint')
    ->assertOk();

test('`--dump` option')
    ->artisan('blueprint', [
        '--dump' => true,
    ])
    ->assertOk();
