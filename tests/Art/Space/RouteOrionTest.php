<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('generate a api.php route file')
    ->expect(fn () => Draft::new('User')->set('endpoint', 'user')->set('reuse', false)->art('route:orion', 'space'))
    ->filename()
    ->toEndWith('routes/api.php')
    ->generate()
    ->toMatchSnapshot();
