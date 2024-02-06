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
                ],
                'ibge_code' => [
                    'fillable' => true,
                ],
            ],
        ],
        'state' => [
            'type' => 'model',
            'name' => 'State',
            'attributes' => [
                'name' => [
                    'fillable' => true,
                ],
                'country_id' => [
                    'fillable' => true,
                ],
                'ibge_code' => [
                    'fillable' => true,
                ],
            ],
        ],
    ],
];
