<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a model')
    ->expect(fn () => Factory::art('User', 'model', 'studio'))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a model with `fillable` property')
    ->expect(fn () => Factory::art('User', 'model', 'studio', [
        ...Draft::new('User')
            ->attribute()->string('name')->fillable()
            ->draft()
            ->toArray(),
    ]))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();

test('generate a model with `table` property')
    ->expect(fn () => Factory::art('User', 'model', 'studio', [
        'table' => 'studio_user',
    ]))
    ->filename()
    ->toEndWith('src/Models/User.php')
    ->generate()
    ->toMatchSnapshot();
