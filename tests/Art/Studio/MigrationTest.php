<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a migration')
    ->expect(fn () => Draft::new('User')->art('migration', 'studio'))
    ->filename()
    ->toContain('database/migrations/')
    ->toEndWith('_000000_user.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table')
    ->expect(fn () => Draft::new('User')->art('migration:create', 'studio'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to create a table with columns')
    ->expect(fn () => Draft::new('User')
        ->attribute()->integer('id')->primary()
        ->attribute()->foreign('group_id')->index()
        ->attribute()->string('name')
        ->attribute()->string('email')->unique()
        ->attribute()->integer('age')->nullable()->default(18)
        ->attribute()->boolean('active')->default(false)
        ->attribute()->timestamps()
        ->draft()
        ->art('migration:create', 'studio')
    )
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_000000_create_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to add foreign key with columns')
    ->expect(fn () => Draft::new('User')
        ->attribute()->foreign('group_id')->index()
        ->draft()
        ->art('migration:foreign', 'studio')
    )
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_100000_add_foreign_key_in_user_table.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a migration to add foreign key')
    ->expect(fn () => Draft::new('User')->art('migration:foreign', 'studio'))
    ->filename()
    ->toEndWith('database/migrations/0000_00_00_100000_add_foreign_key_in_user_table.php')
    ->generate()
    ->toMatchSnapshot();
