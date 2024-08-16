<?php

declare(strict_types=1);

test('`studio` command exists')
    ->artisan('studio', [
        'file' => 'workbench/resources/studio.php',
    ])
    ->assertOk();

test('`--dump` option')
    ->artisan('studio', [
        'file' => 'workbench/resources/studio.php',
        '--dump' => true,
    ])
    ->assertOk();

test('`--file` option')
    ->artisan('studio', [
        'file' => 'workbench/resources/studio.php',
        '--preset' => 'temporary',
        '--file' => true,
    ])
    ->assertOk();
