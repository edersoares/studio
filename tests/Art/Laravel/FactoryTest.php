<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a factory')
    ->expect(fn () => Factory::art('User', 'factory', 'laravel'))
    ->filename()
    ->toEndWith('database/factories/UserFactory.php')
    ->generate()
    ->toMatchSnapshot();
