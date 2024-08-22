<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a model')
    ->expect(fn () => Draft::new('User')->art('model', 'studio'))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a model with `fillable` property')
    ->expect(fn () => Draft::new('User')
        ->set('table', 'user')
        ->attribute()->string('name')->fillable()
        ->draft()
        ->art('model', 'studio'))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a model with `table` property')
    ->expect(fn () => Draft::new('User')->set('table', 'studio_user')->art('model', 'studio'))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();
