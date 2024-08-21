<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a migration')
    ->expect(fn () => Factory::art('User', 'migration', 'studio'))
    ->filename()
    ->toContain('database/migrations/')
    ->toEndWith('_000000_user.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table')
    ->expect(fn () => Factory::art('User', 'migration:create', 'studio'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table with columns')
    ->expect(fn () => Factory::art('User', 'migration:create', 'studio', [
        ...Draft::new('User')
            ->attribute()->integer('id')->primary()
            ->attribute()->foreign('group_id')->index()
            ->attribute()->string('name')
            ->attribute()->string('email')->unique()
            ->attribute()->integer('age')->nullable()->default(18)
            ->attribute()->boolean('active')->default(false)
            ->attribute()->timestamps()
            ->draft()
            ->toArray(),
    ]))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to add foreign key with columns')
    ->expect(fn () => Factory::art('User', 'migration:foreign', 'studio', [
        ...Draft::new('User')
            ->attribute()->foreign('group_id')->index()
            ->draft()
            ->toArray(),
    ]))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_100000_add_foreign_key_in_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to add foreign key')
    ->expect(fn () => Factory::art('User', 'migration:foreign', 'studio'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_100000_add_foreign_key_in_user_table.php')
    ->generate()
    ->toMatchSnapshot();
