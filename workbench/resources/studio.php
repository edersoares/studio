<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

return [

    'preset' => 'studio',

    'drafts' => [

        Draft::new('User')
            ->set('table', 'user')
            ->attribute()->id()
            ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('name')
            ->attribute()->string('email')->unique()->fillable()->required()->min(3)->faker('email')
            ->attribute()->string('password')->fillable()->required()->min(8)->max(48)->faker('lexify', '########')
            ->attribute()->timestamps()
            ->relation()->belongsTo('Group')
            ->relation()->hasMany('Role')
            ->relation()->hasOne('Role')
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->push('generate', 'factory')
            ->push('generate', 'controller')
            ->push('generate', 'request')
            ->push('generate', 'tester')
            ->data(),

    ],

];
