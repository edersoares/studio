<?php

declare(strict_types=1);

use function Orchestra\Testbench\package_path;
use function Orchestra\Testbench\workbench_path;

return [

    'preset' => env('STUDIO_PRESET', 'studio'),

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
                    'use' => Dex\Laravel\Studio\Art\Laravel\Controller::class,
                    'path' => 'Http/Controllers',
                    'namespace' => 'Http\\Controllers',
                    'suffix' => 'Controller',
                ],

                'model' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\Model::class,
                    'path' => 'Models',
                    'namespace' => 'Models',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                    'traits' => [
                        Illuminate\Database\Eloquent\Factories\HasFactory::class,
                    ],
                ],

                'factory' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\Factory::class,
                    'kind' => 'database',
                    'path' => 'factories',
                    'namespace' => 'Factories',
                    'suffix' => 'Factory',
                    'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
                ],

                'migration' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\Migration::class,
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return now()->format('Y_m_d') . '_000000_' . str($name)->snake()->value();
                    },
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:create' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\MigrationCreate::class,
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_000000_create_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'Create',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:foreign' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\MigrationForeign::class,
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_100000_add_foreign_key_in_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'AddForeignKeyIn',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'policy' => [
                    'path' => 'Policies',
                    'namespace' => 'Policies',
                ],

                'seeder' => [
                    'kind' => 'database',
                    'path' => 'seeders',
                    'suffix' => 'Seeder',
                ],

                'request' => [
                    'use' => Dex\Laravel\Studio\Art\Laravel\Request::class,
                    'path' => 'Http/Requests',
                    'suffix' => 'Request',
                    'namespace' => 'Http\\Requests',
                    'extends' => Illuminate\Foundation\Http\FormRequest::class,
                ],

            ],

        ],

        'studio' => [

            'extends' => ['laravel'],

            'path' => getcwd(),

            'paths' => [
                'source' => env('STUDIO_SOURCE_PATH', 'src'),
            ],

            'namespace' => env('STUDIO_NAMESPACE', 'Package'),

            'namespaces' => [
                'source' => env('STUDIO_SOURCE_NAMESPACE', ''),
                'database' => env('STUDIO_DATABASE_NAMESPACE', 'Database'),
                'tests' => env('STUDIO_TESTS_NAMESPACE', 'Tests'),
            ],

            'drafts' => [

                'class' => [
                    'use' => Dex\Laravel\Studio\Art\Studio\PhpFile::class,
                ],

                'model' => [
                    'use' => Dex\Laravel\Studio\Art\Studio\Model::class,
                ],

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
                    'kind' => 'database',
                    'filename' => function (string $type, string $name) {
                        return now()->format('Y_m_d') . '_000000_' . str($name)->snake()->value();
                    },
                ],

                'migration:create' => [
                    'use' => Dex\Laravel\Studio\Art\Studio\MigrationCreate::class,
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_000000_create_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'Create',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:foreign' => [
                    'use' => Dex\Laravel\Studio\Art\Studio\MigrationForeign::class,
                    'kind' => 'database',
                    'path' => 'migrations',
                    'filename' => function (string $type, string $name) {
                        return '0000_00_00_100000_add_foreign_key_in_' . str($name)->snake()->value() . '_table';
                    },
                    'prefix' => 'AddForeignKeyIn',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'tester' => [
                    'use' => Dex\Laravel\Studio\Art\Studio\Tester::class,
                    'kind' => 'tests',
                    'path' => 'Tester',
                    'suffix' => 'Test',
                ],

            ],

        ],

        'package' => [

            'extends' => ['laravel', 'studio'],

            'path' => package_path(),

        ],

        'workbench' => [

            'extends' => ['laravel', 'studio'],

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

            'extends' => ['laravel', 'studio'],

            'path' => package_path('tmp'),

        ],

    ],

];
