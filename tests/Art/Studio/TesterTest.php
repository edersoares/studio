<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a tester')
    ->expect(fn () => Draft::new('User')
        ->set('table', 'user')
        ->attribute()->id()
        ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('name')
        ->attribute()->string('email')->unique()->fillable()->required()->min(3)->faker('email')
        ->attribute()->string('password')->fillable()->required()->min(8)->max(48)->faker('lexify', '########')
        ->attribute()->timestamps()
        ->relation()->belongsTo('Group')
        ->relation()->hasMany('Profile')
        ->draft()
        ->art('tester', 'studio'))
    ->filename()
    ->toEndWith('tests/Tester/UserTest.php')
    ->generate()
    ->toMatchSnapshot();
