<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Art\Laravel\Model;
use Dex\Laravel\Studio\Blueprint\Factory;

test('generate a model', function () {
    $model = new Model(
        draft: Factory::draft('model', 'User'),
        preset: Factory::preset('laravel')
    );

    expect($model->generate())
        ->toMatchSnapshot()
        ->and($model->filename())
        ->toEndWith('app/Models/User.php');
});
