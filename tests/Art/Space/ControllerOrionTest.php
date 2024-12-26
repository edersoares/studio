<?php

declare(strict_types=1);

test('generate a Orion controller')
    ->expect(fn () => draft('User')
        ->attribute()->string('name')->fillable()->searchable()->sortable()
        ->attribute()->boolean('active')->default(true)->filterable()->sortable()
        ->attribute()->timestamp('left_at')
        ->attribute()->softDeletes()
        ->relation()->belongsTo('User', 'manager')->includable()
        ->draft()
        ->art('controller:orion', 'space')
    )
    ->filename()
    ->toEndWith('src/Http/Controllers/UserController.php')
    ->generate()
    ->toMatchSnapshot();
