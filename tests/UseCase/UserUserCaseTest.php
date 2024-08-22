<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

test('new draft')
    ->expect(fn () => Draft::new('User')->data())
    ->toBe([
        'name' => 'User',
    ]);

test('draft with attributes (database columns)')
    ->expect(fn () => Draft::new('User')
        ->attribute()->id()
        ->attribute()->uuid('account')
        ->attribute()->foreign('group_id')
        ->attribute()->string('name')
        ->attribute()->text('bio')
        ->attribute()->integer('age')
        ->attribute()->float('salary')
        ->attribute()->boolean('active')
        ->attribute()->timestamps()
        ->attribute()->softDeletes()
        ->draft()
        ->data()
    )
    ->toBe([
        'name' => 'User',
        'attributes' => [
            'id' => [
                'name' => 'id',
                'type' => 'id',
            ],
            'account' => [
                'name' => 'account',
                'type' => 'uuid',
            ],
            'group_id' => [
                'name' => 'group_id',
                'type' => 'foreignId',
                'foreign' => 'group.id',
            ],
            'name' => [
                'name' => 'name',
                'type' => 'string',
            ],
            'bio' => [
                'name' => 'bio',
                'type' => 'text',
            ],
            'age' => [
                'name' => 'age',
                'type' => 'integer',
            ],
            'salary' => [
                'name' => 'salary',
                'type' => 'float',
            ],
            'active' => [
                'name' => 'active',
                'type' => 'boolean',
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
    ]);

test('draft with attributes (database options)')
    ->expect(fn () => Draft::new('User')
        ->attribute()->uuid()->primary()
        ->attribute()->string('email')->unique()
        ->attribute()->integer('age')->index()
        ->attribute()->float('salary')->nullable()
        ->attribute()->boolean('active')->default(false)
        ->draft()
        ->data()
    )
    ->toBe([
        'name' => 'User',
        'attributes' => [
            'uuid' => [
                'name' => 'uuid',
                'type' => 'uuid',
                'primary' => true,
            ],
            'email' => [
                'name' => 'email',
                'type' => 'string',
                'unique' => true,
            ],
            'age' => [
                'name' => 'age',
                'type' => 'integer',
                'index' => true,
            ],
            'salary' => [
                'name' => 'salary',
                'type' => 'float',
                'nullable' => true,
            ],
            'active' => [
                'name' => 'active',
                'type' => 'boolean',
                'default' => false,
            ],
        ],
    ]);

test('draft with attributes (factory options)')
    ->expect(fn () => Draft::new('User')
        ->attribute()->id()
        ->attribute()->foreign('group_id')->factory('Group')
        ->attribute()->string('name')->faker('name')
        ->draft()
        ->data()
    )
    ->toBe([
        'name' => 'User',
        'attributes' => [
            'id' => [
                'name' => 'id',
                'type' => 'id',
            ],
            'group_id' => [
                'name' => 'group_id',
                'type' => 'foreignId',
                'foreign' => 'group.id',
                'factory' => [
                    'model' => ['Group'],
                ],
            ],
            'name' => [
                'name' => 'name',
                'type' => 'string',
                'factory' => [
                    'faker' => ['name'],
                ],
            ],
        ],
    ]);

test('draft with attributes (model options)')
    ->expect(fn () => Draft::new('User')
        ->attribute()->id()
        ->attribute()->string('name')->fillable()
        ->attribute()->integer('age')->fillable()
        ->draft()
        ->data()
    )
    ->toBe([
        'name' => 'User',
        'attributes' => [
            'id' => [
                'name' => 'id',
                'type' => 'id',
            ],
            'name' => [
                'name' => 'name',
                'type' => 'string',
                'fillable' => true,
            ],
            'age' => [
                'name' => 'age',
                'type' => 'integer',
                'fillable' => true,
            ],
        ],
    ]);

test('draft with attributes (validation rules)')
    ->expect(fn () => Draft::new('User')
        ->attribute()->id()
        ->attribute()->string('name')->required()->min(3)->max(50)
        ->attribute()->integer('age')->size(2)
        ->draft()
        ->data()
    )
    ->toBe([
        'name' => 'User',
        'attributes' => [
            'id' => [
                'name' => 'id',
                'type' => 'id',
            ],
            'name' => [
                'name' => 'name',
                'type' => 'string',
                'validation' => [
                    'rules' => [
                        'required',
                        'min:3',
                        'max:50',
                    ],
                ],
            ],
            'age' => [
                'name' => 'age',
                'type' => 'integer',
                'validation' => [
                    'rules' => [
                        'size:2',
                    ],
                ],
            ],
        ],
    ]);
