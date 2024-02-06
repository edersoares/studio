<?php

declare(strict_types=1);

return [
    'drafts' => [
        'country' => [
            'type' => 'model',
            'name' => 'Country',
            'attributes' => [
                'id' => [
                    'type' => 'id',
                ],
                'name' => [
                    'type' => 'string',
                    'fillable' => true,
                    'index' => true,
                    'factory' => 'faker:country',
                ],
                'ibge_code' => [
                    'type' => 'integer',
                    'fillable' => true,
                    'nullable' => true,
                    'factory' => 'faker:numerify:######',
                ],
                'timestamps' => [
                    'type' => 'timestamps',
                ],
                'softDeletes' => [
                    'type' => 'softDeletes',
                ],
            ],
            'relations' => [
                'states' => [
                    'model' => 'State',
                    'type' => 'hasMany',
                ],
            ],
        ],
        'state' => [
            'type' => 'model',
            'name' => 'State',
            'attributes' => [
                'id' => [
                    'type' => 'id',
                ],
                'country_id' => [
                    'type' => 'foreign',
                    'fillable' => true,
                    'factory' => 'model:Country',
                ],
                'name' => [
                    'type' => 'string',
                    'fillable' => true,
                    'index' => true,
                    'factory' => 'faker:colorName',
                ],
                'ibge_code' => [
                    'type' => 'integer',
                    'fillable' => true,
                    'nullable' => true,
                    'factory' => 'faker:numerify:######',
                ],
                'active' => [
                    'type' => 'boolean',
                    'fillable' => true,
                    'default' => true,
                    'factory' => 'faker:boolean',
                ],
                'timestamps' => [
                    'type' => 'timestamps',
                ],
                'softDeletes' => [
                    'type' => 'softDeletes',
                ],
            ],
            'relations' => [
                'country' => [
                    'model' => 'Country',
                    'type' => 'belongsTo',
                ],
            ],
        ],
    ],
];
