<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a model')
    ->expect(fn () => Factory::art('User', 'model', 'laravel'))
    ->filename()
    ->toEndWith('app/Models/User.php')
    ->generate()
    ->toMatchSnapshot();
