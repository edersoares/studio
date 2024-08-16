<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;

return [

    'preset' => 'laravel',

    'drafts' => [

        Draft::new('User')
            ->attribute()->id()
            ->attribute()->string('name')
            ->attribute()->string('email')
            ->attribute()->string('password')
            ->draft()
            ->generate('model')
            ->toArray(),

    ],

];
