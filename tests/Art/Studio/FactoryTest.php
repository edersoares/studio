<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a factory')
    ->expect(fn () => Draft::new('User')->art('factory', 'studio'))
    ->filename()
    ->toEndWith('database/factories/UserFactory.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a factory using faker')
    ->expect(fn () => Draft::new('User')
        ->attribute()->string('name')->faker('name')
        ->draft()
        ->art('factory', 'studio')
    )
    ->filename()
    ->toEndWith('database/factories/UserFactory.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a factory using model factory')
    ->expect(fn () => Draft::new('User')
        ->attribute()->foreign('group')->factory('Group')
        ->draft()
        ->art('factory', 'studio')
    )
    ->filename()
    ->toEndWith('database/factories/UserFactory.php')
    ->generate()
    ->toMatchSnapshot();
