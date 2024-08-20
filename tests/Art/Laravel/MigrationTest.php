<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a migration')
    ->expect(fn () => Factory::art('User', 'migration', 'laravel'))
    ->filename()
    ->toContain('database/migrations/')
    ->toEndWith('_000000_user.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table')
    ->expect(fn () => Factory::art('User', 'migration:create', 'laravel'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();
