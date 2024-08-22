<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a class')
    ->expect(fn () => Draft::new('User')->art('class', 'studio'))
    ->filename()
    ->toEndWith('src/User.php')
    ->generate()
    ->toMatchSnapshot();
