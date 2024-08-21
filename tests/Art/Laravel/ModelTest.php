<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;

test('generate a model')
    ->expect(fn () => Draft::new('User')->art('model', 'laravel'))
    ->filename()
    ->toEndWith('app/Models/User.php')
    ->generate()
    ->toMatchSnapshot();
