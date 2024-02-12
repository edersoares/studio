<?php

declare(strict_types=1);

test('`blueprint` command exists')
    ->artisan('blueprint', [
        'file' => 'workbench/resources/blueprint.php',
    ])
    ->assertOk();

test('`--dump` option')
    ->artisan('blueprint', [
        'file' => 'workbench/resources/blueprint.php',
        '--dump' => true,
    ])
    ->assertOk();

test('`--file` option')
    ->artisan('blueprint', [
        'file' => 'workbench/resources/blueprint.php',
        '--preset' => 'temporary',
        '--file' => true,
    ])
    ->assertOk();
