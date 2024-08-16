<?php

use Dex\Laravel\Studio\Blueprint\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;

test('generate a class with trait', function () {
    config([
        'studio.preset' => 'laravel',
        'studio.presets.laravel.drafts.model.traits' => [
            SoftDeletes::class,
        ],
    ]);

    expect(Factory::generate('model', 'User'))->toMatchSnapshot();
});
