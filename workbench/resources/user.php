<?php

use Dex\Laravel\Studio\Blueprint\Draft;

return [

    'preset' => 'studio',

    'drafts' => [

        Draft::new('User')
            ->attribute()->id()
            ->attribute()->foreign('user_id')
            ->attribute()->string('name')->fillable()->faker('name')
            ->attribute()->string('email')->fillable()
            ->attribute()->string('password')->fillable()
            ->attribute()->timestamps()
            ->draft()
            ->generate('model')
            ->generate('migration:create')
            ->generate('migration:foreign')
            ->generate('factory')
            ->toArray(),

    ],

];
