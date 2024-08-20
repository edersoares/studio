<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a class')
    ->expect(fn () => Factory::art('User', 'class', 'studio'))
    ->filename()
    ->toEndWith('src/User.php')
    ->generate()
    ->toMatchSnapshot();
