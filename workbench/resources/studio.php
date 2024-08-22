<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

return [

    'preset' => 'studio',

    'drafts' => [

        Draft::new('User')
            ->attribute()->id()
            ->attribute()->string('name')->required()->min(3)->max(5)->faker('name')
            ->attribute()->string('email')
            ->attribute()->string('password')
            ->relation()->belongsTo('Group')
            ->relation()->hasMany('Post')
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->push('generate', 'factory')
            ->push('generate', 'tester')
            ->data(),

    ],

];
