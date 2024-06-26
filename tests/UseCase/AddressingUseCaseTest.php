<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Draft;

test('Country')->expect(
    Draft::new('Country')
        ->attribute()->id()->docs('ID')->example(1)
        ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('country')->docs('Nome')->example('Brasil')
        ->attribute()->integer('ibge_code')->fillable()->size(8)->nullable()->unique()->faker('numerify', '########')->docs('Código IBGE')->example(12345678)
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->relation()->hasMany('states')
        ->model()
        ->toArray()
)->toBe([
    'type' => 'model',
    'name' => 'Country',
    'model' => 'Country',
    'table' => 'country',
    'attributes' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'docs' => [
                'description' => 'ID',
                'example' => 1,
            ],
        ],
        'name' => [
            'name' => 'name',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:3',
                    'max:50',
                ],
            ],
            'factory' => [
                'faker' => ['country'],
            ],
            'docs' => [
                'description' => 'Nome',
                'example' => 'Brasil',
            ],
        ],
        'ibge_code' => [
            'name' => 'ibge_code',
            'type' => 'integer',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'size:8',
                ],
            ],
            'nullable' => true,
            'unique' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Código IBGE',
                'example' => 12345678,
            ],
        ],
        'timestamps' => [
            'name' => 'timestamps',
            'type' => 'timestamps',
        ],
        'softDeletes' => [
            'name' => 'softDeletes',
            'type' => 'softDeletes',
        ],
    ],
    'relations' => [
        'states' => [
            'name' => 'states',
            'model' => 'State',
            'type' => 'hasMany',
        ],
    ],
]);

test('State')->expect(
    Draft::new('State')
        ->attribute()->id()->docs('ID')->example(1)
        ->attribute()->foreign('country_id')->fillable()->factory('Country')->docs('ID do país')->example(1)
        ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->index()->faker('colorName')->docs('Nome')->example('Rio Grade do Sul')
        ->attribute()->string('abbreviation')->fillable()->required()->min(1)->max(5)->nullable()->faker('colorName')->docs('Sigla')->example('RS')
        ->attribute()->integer('ibge_code')->fillable()->size(8)->nullable()->unique()->faker('numerify', '########')->docs('Código IBGE')->example(11223344)
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->relation()->belongsTo('country')
        ->relation()->hasMany('cities')
        ->model()
        ->toArray()
)->toBe([
    'type' => 'model',
    'name' => 'State',
    'model' => 'State',
    'table' => 'state',
    'attributes' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'docs' => [
                'description' => 'ID',
                'example' => 1,
            ],
        ],
        'country_id' => [
            'name' => 'country_id',
            'type' => 'foreignId',
            'foreign' => 'country.id',
            'fillable' => true,
            'factory' => [
                'model' => [
                    'Country',
                ],
            ],
            'docs' => [
                'description' => 'ID do país',
                'example' => 1,
            ],
        ],
        'name' => [
            'name' => 'name',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:3',
                    'max:50',
                ],
            ],
            'index' => true,
            'factory' => [
                'faker' => ['colorName'],
            ],
            'docs' => [
                'description' => 'Nome',
                'example' => 'Rio Grade do Sul',
            ],
        ],
        'abbreviation' => [
            'name' => 'abbreviation',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:1',
                    'max:5',
                ],
            ],
            'nullable' => true,
            'factory' => [
                'faker' => ['colorName'],
            ],
            'docs' => [
                'description' => 'Sigla',
                'example' => 'RS',
            ],
        ],
        'ibge_code' => [
            'name' => 'ibge_code',
            'type' => 'integer',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'size:8',
                ],
            ],
            'nullable' => true,
            'unique' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Código IBGE',
                'example' => 11223344,
            ],
        ],
        'timestamps' => [
            'name' => 'timestamps',
            'type' => 'timestamps',
        ],
        'softDeletes' => [
            'name' => 'softDeletes',
            'type' => 'softDeletes',
        ],
    ],
    'relations' => [
        'country' => [
            'name' => 'country',
            'model' => 'Country',
            'type' => 'belongsTo',
        ],
        'cities' => [
            'name' => 'cities',
            'model' => 'City',
            'type' => 'hasMany',
        ],
    ],
]);

test('City')->expect(
    Draft::new('City')
        ->attribute()->id()->docs('ID')->example(1)
        ->attribute()->foreign('state_id')->fillable()->factory('State')->docs('ID do estado')->example(1)
        ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('city')->docs('Nome')->example('Porto Alegre')
        ->attribute()->integer('ibge_code')->fillable()->size(8)->nullable()->unique()->faker('numerify', '########')->docs('Código IBGE')->example(12345678)
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->relation()->belongsTo('state')
        ->relation()->hasMany('places')
        ->model()
        ->toArray()
)->toBe([
    'type' => 'model',
    'name' => 'City',
    'model' => 'City',
    'table' => 'city',
    'attributes' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'docs' => [
                'description' => 'ID',
                'example' => 1,
            ],
        ],
        'state_id' => [
            'name' => 'state_id',
            'type' => 'foreignId',
            'foreign' => 'state.id',
            'fillable' => true,
            'factory' => [
                'model' => [
                    'State',
                ],
            ],
            'docs' => [
                'description' => 'ID do estado',
                'example' => 1,
            ],
        ],
        'name' => [
            'name' => 'name',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:3',
                    'max:50',
                ],
            ],
            'factory' => [
                'faker' => ['city'],
            ],
            'docs' => [
                'description' => 'Nome',
                'example' => 'Porto Alegre',
            ],
        ],
        'ibge_code' => [
            'name' => 'ibge_code',
            'type' => 'integer',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'size:8',
                ],
            ],
            'nullable' => true,
            'unique' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Código IBGE',
                'example' => 12345678,
            ],
        ],
        'timestamps' => [
            'name' => 'timestamps',
            'type' => 'timestamps',
        ],
        'softDeletes' => [
            'name' => 'softDeletes',
            'type' => 'softDeletes',
        ],
    ],
    'relations' => [
        'state' => [
            'name' => 'state',
            'model' => 'State',
            'type' => 'belongsTo',
        ],
        'places' => [
            'name' => 'places',
            'model' => 'Place',
            'type' => 'hasMany',
        ],
    ],
]);

test('Place')->expect(
    Draft::new('Place')
        ->attribute()->id()->docs('ID')->example(1)
        ->attribute()->foreign('city_id')->fillable()->factory('City')->docs('ID da cidade')->example(1)
        ->attribute()->string('address')->fillable()->required()->min(3)->max(50)->nullable()->faker('address')->docs('Endereço')->example('Rua do Centro')
        ->attribute()->string('number')->fillable()->nullable()->faker('numerify', '########')->docs('Número')->example(123)
        ->attribute()->string('complement')->fillable()->nullable()->faker('numerify', '########')->docs('Complemento')->example('Sala')
        ->attribute()->string('neighborhood')->fillable()->nullable()->faker('numerify', '########')->docs('Bairro')->example('Centro')
        ->attribute()->string('postal_code')->fillable()->nullable()->faker('numerify', '########')->docs('CEP')->example('12345-000')
        ->attribute()->float('latitude')->fillable()->nullable()->faker('latitude')->docs('Latitude')->example(0)
        ->attribute()->float('longitude')->fillable()->nullable()->faker('longitude')->docs('Longitude')->example(0)
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->relation()->belongsTo('city')
        ->model()
        ->toArray()
)->toBe([
    'type' => 'model',
    'name' => 'Place',
    'model' => 'Place',
    'table' => 'place',
    'attributes' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'docs' => [
                'description' => 'ID',
                'example' => 1,
            ],
        ],
        'city_id' => [
            'name' => 'city_id',
            'type' => 'foreignId',
            'foreign' => 'city.id',
            'fillable' => true,
            'factory' => [
                'model' => [
                    'City',
                ],
            ],
            'docs' => [
                'description' => 'ID da cidade',
                'example' => 1,
            ],
        ],
        'address' => [
            'name' => 'address',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:3',
                    'max:50',
                ],
            ],
            'nullable' => true,
            'factory' => [
                'faker' => ['address'],
            ],
            'docs' => [
                'description' => 'Endereço',
                'example' => 'Rua do Centro',
            ],
        ],
        'number' => [
            'name' => 'number',
            'type' => 'string',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Número',
                'example' => 123,
            ],
        ],
        'complement' => [
            'name' => 'complement',
            'type' => 'string',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Complemento',
                'example' => 'Sala',
            ],
        ],
        'neighborhood' => [
            'name' => 'neighborhood',
            'type' => 'string',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Bairro',
                'example' => 'Centro',
            ],
        ],
        'postal_code' => [
            'name' => 'postal_code',
            'type' => 'string',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'CEP',
                'example' => '12345-000',
            ],
        ],
        'latitude' => [
            'name' => 'latitude',
            'type' => 'float',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['latitude'],
            ],
            'docs' => [
                'description' => 'Latitude',
                'example' => 0,
            ],
        ],
        'longitude' => [
            'name' => 'longitude',
            'type' => 'float',
            'fillable' => true,
            'nullable' => true,
            'factory' => [
                'faker' => ['longitude'],
            ],
            'docs' => [
                'description' => 'Longitude',
                'example' => 0,
            ],
        ],
        'timestamps' => [
            'name' => 'timestamps',
            'type' => 'timestamps',
        ],
        'softDeletes' => [
            'name' => 'softDeletes',
            'type' => 'softDeletes',
        ],
    ],
    'relations' => [
        'city' => [
            'name' => 'city',
            'model' => 'City',
            'type' => 'belongsTo',
        ],
    ],
]);

test('District')->expect(
    Draft::new('District')
        ->attribute()->id()->docs('ID')->example(1)
        ->attribute()->foreign('city_id')->fillable()->factory('City')->docs('ID da cidade')->example(1)
        ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('city')->docs('Nome')->example('Centro')
        ->attribute()->integer('ibge_code')->fillable()->size(8)->nullable()->unique()->faker('numerify', '########')->docs('Código IBGE')->example(1234567890)
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->relation()->belongsTo('city')
        ->model()
        ->toArray()
)->toBe([
    'type' => 'model',
    'name' => 'District',
    'model' => 'District',
    'table' => 'district',
    'attributes' => [
        'id' => [
            'name' => 'id',
            'type' => 'id',
            'docs' => [
                'description' => 'ID',
                'example' => 1,
            ],
        ],
        'city_id' => [
            'name' => 'city_id',
            'type' => 'foreignId',
            'foreign' => 'city.id',
            'fillable' => true,
            'factory' => [
                'model' => [
                    'City',
                ],
            ],
            'docs' => [
                'description' => 'ID da cidade',
                'example' => 1,
            ],
        ],
        'name' => [
            'name' => 'name',
            'type' => 'string',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'required',
                    'min:3',
                    'max:50',
                ],
            ],
            'factory' => [
                'faker' => ['city'],
            ],
            'docs' => [
                'description' => 'Nome',
                'example' => 'Centro',
            ],
        ],
        'ibge_code' => [
            'name' => 'ibge_code',
            'type' => 'integer',
            'fillable' => true,
            'validation' => [
                'rules' => [
                    'size:8',
                ],
            ],
            'nullable' => true,
            'unique' => true,
            'factory' => [
                'faker' => ['numerify', '########'],
            ],
            'docs' => [
                'description' => 'Código IBGE',
                'example' => 1234567890,
            ],
        ],
        'timestamps' => [
            'name' => 'timestamps',
            'type' => 'timestamps',
        ],
        'softDeletes' => [
            'name' => 'softDeletes',
            'type' => 'softDeletes',
        ],
    ],
    'relations' => [
        'city' => [
            'name' => 'city',
            'model' => 'City',
            'type' => 'belongsTo',
        ],
    ],
]);
