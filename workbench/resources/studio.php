<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

return [

    'preset' => 'studio',

    'drafts' => [

        Draft::new('User')
            ->set('table', 'user')
            ->attribute()->id()
            ->attribute()->string('name')->fillable()->required()->min(3)->max(5)->faker('name')
            ->attribute()->timestamps()
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->push('generate', 'factory')
            ->push('generate', 'controller')
            ->push('generate', 'tester')
            ->data(),

    ],

];
