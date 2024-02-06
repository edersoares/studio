<?php

declare(strict_types=1);

return [
    'drafts' => [
        'country' => [
            'type' => 'model',
            'name' => 'Country',
            'attributes' => [
                'name' => [
                    'fillable' => true,
                    'factory' => 'faker:country',
                ],
                'ibge_code' => [
                    'fillable' => true,
                    'factory' => 'faker:numerify:######',
                ],
            ],
        ],
        'state' => [
            'type' => 'model',
            'name' => 'State',
            'attributes' => [
                'name' => [
                    'fillable' => true,
                    'factory' => 'faker:colorName',
                ],
                'country_id' => [
                    'fillable' => true,
                    'factory' => 'model:Country',
                ],
                'ibge_code' => [
                    'fillable' => true,
                    'factory' => 'faker:numerify:######',
                ],
            ],
        ],
    ],
];
