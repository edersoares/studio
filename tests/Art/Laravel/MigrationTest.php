<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a migration')
    ->expect(fn () => Factory::art('User', 'migration', 'laravel'))
    ->filename()
    ->toContain('database/migrations/')
    ->toEndWith('_000000_user.php')
    ->generate()
    ->toMatchSnapshot();
