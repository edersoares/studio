<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a migration')
    ->expect(fn () => Draft::new('User')->art('migration', 'laravel'))
    ->filename()
    ->toContain('database/migrations/')
    ->toEndWith('_000000_user.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table')
    ->expect(fn () => Draft::new('User')->art('migration:create', 'laravel'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to add foreign key')
    ->expect(fn () => Draft::new('User')->art('migration:foreign', 'laravel'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_100000_add_foreign_key_in_user_table.php')
    ->generate()
    ->toMatchSnapshot();
