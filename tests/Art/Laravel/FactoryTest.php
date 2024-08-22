<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a factory')
    ->expect(fn () => Draft::new('User')->art('factory', 'laravel'))
    ->filename()
    ->toEndWith('database/factories/UserFactory.php')
    ->generate()
    ->toMatchSnapshot();
