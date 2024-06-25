<?php

declare(strict_types=1);

use function Orchestra\Testbench\package_path;
use function Orchestra\Testbench\workbench_path;

return [

    'preset' => env('STUDIO_PRESET', 'workbench'),

    'presets' => [

        'laravel' => [

            'path' => base_path(),

            'paths' => [
                'source' => 'app',
                'database' => 'database',
                'tests' => 'tests',
            ],

            'namespace' => '',

            'namespaces' => [
                'source' => 'App',
                'database' => 'Database',
                'tests' => 'Tests',
            ],

            'drafts' => [

                'command' => [
                    'path' => 'Console/Commands',
                ],

                'controller' => [
                    'path' => 'Http/Controllers',
                ],

                'model' => [
                    'path' => 'Models',
                    'namespace' => 'Models',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

                'factory' => [
                    'kind' => 'database',
                    'path' => 'factories',
                    'namespace' => 'Factories',
                    'suffix' => 'Factory',
                    'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
                ],

                'migration' => [
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return now()->format('Y_m_d') . '_000000_' . str($name)->snake()->value();
                    },
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'seeder' => [
                    'kind' => 'database',
                    'path' => 'seeders',
                    'suffix' => 'Seeder',
                ],

                'request' => [
                    'path' => 'Http/Request',
                    'suffix' => 'Request',
                ],

            ],

        ],

        'package' => [

            'extends' => ['laravel'],

            'path' => package_path(),

            'paths' => [
                'source' => env('STUDIO_SOUCE_PATH', 'src'),
            ],

            'namespace' => env('STUDIO_NAMESPACE', 'Package'),

            'namespaces' => [
                'source' => env('STUDIO_SOURCE_NAMESPACE', ''),
                'database' => env('STUDIO_DATABASE_NAMESPACE', 'Database'),
                'tests' => env('STUDIO_TESTS_NAMESPACE', 'Tests'),
            ],

            'drafts' => [

                'builder' => [
                    'namespace' => 'Models\\Builder',
                    'path' => 'Models/Builder',
                    'suffix' => 'Builder',
                    'extends' => Illuminate\Database\Eloquent\Builder::class,
                    'methods' => [
                        [
                            'name' => 'active',
                            'return' => '$this',
                            'body' => 'return $this->where(\'active\', true);',
                        ],
                    ],
                ],

                'eloquent' => [
                    'namespace' => 'Models\\Eloquent',
                    'path' => 'Models/Eloquent',
                    'suffix' => 'Eloquent',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

                'migration' => [
                    'filename' => function (string $type, string $name) {
                        return now()->format('Y_m_d') . '_000000_' . str($name)->snake()->value();
                    },
                ],

                'migration:create' => [
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_000000_create_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'Create',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:foreign' => [
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_100000_add_foreign_key_in_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'AddForeignKeyIn',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

            ],

        ],

        'workbench' => [

            'extends' => ['laravel', 'package'],

            'path' => workbench_path(),

            'paths' => [
                'source' => 'app',
            ],

            'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench'),

            'namespaces' => [
                'source' => 'App',
            ],

        ],

        'temporary' => [

            'extends' => ['laravel'],

            'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),

            'namespace' => 'Temporary',

        ],

    ],

];
