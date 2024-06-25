<?php

declare(strict_types=1);

use Illuminate\Support\Str;

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
                    'path' => 'source://Console/Commands',
                ],

                'controller' => [
                    'path' => 'source://Http/Controllers',
                ],

                'model' => [
                    'path' => 'source://Models',
                    'extension' => '.php',
                    'namespace' => 'Models',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

                'factory' => [
                    'path' => 'database://factories',
                    'extension' => '.php',
                    'namespace' => 'Factories',
                    'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
                ],

                'migration' => [
                    'path' => 'database://migrations',
                ],

                'seeder' => [
                    'path' => 'database://seederss',
                ],

                'request' => [
                    'path' => 'source://Http/Request',
                ],

            ],

        ],

        'package' => [

            'extends' => 'laravel',

            'path' => package_path(),

            'paths' => [
                'source' => 'src',
            ],

            'namespace' => env('STUDIO_NAMESPACE', 'Package'),

            'namespaces' => [
                'source' => env('STUDIO_NAMESPACE', ''),
                'database' => env('STUDIO_DATABASE_NAMESPACE', 'Database'),
                'tests' => env('STUDIO_TESTS_NAMESPACE', 'Tests'),
            ],

            'drafts' => [

                'model' => [
                    'namespace' => env('STUDIO_NAMESPACE', 'Studio\\Package') . '\\Models',
                    'path' => package_path('src/Models'),
                    'extension' => '.php',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

                'migration' => [
                    'filename' => function (string $type, string $name) {
                        return package_path('database/migrations/' . now()->format('Y_m_d') . '_000000_') . Str::snake($name) . '.php';
                    },
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:create' => [
                    'filename' => function (string $type, string $name) {
                        return package_path('database/migrations/0000_00_00_000000_create_') . Str::snake($name) . '_table.php';
                    },
                    'prefix' => 'Create',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

            ],

        ],

        'workbench' => [

            'extends' => 'laravel',

            'path' => workbench_path(),

            'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench'),

            'namespaces' => [
                'source' => '',
                'database' => 'Database',
            ],

            'drafts' => [

                'builder' => [
                    'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench\\Studio\\Package') . '\\App\\Models\\Builder',
                    'path' => workbench_path('app/Models/Builder'),
                    'suffix' => 'Builder',
                    'extension' => '.php',
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
                    'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench\\Studio\\Package') . '\\App\\Models\\Eloquent',
                    'path' => workbench_path('app/Models/Eloquent'),
                    'suffix' => 'Eloquent',
                    'extension' => '.php',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

                'factory' => [
                    'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench\\Studio\\Package') . '\\Database\\Factories',
                    'path' => workbench_path('database/factories'),
                    'suffix' => 'Factory',
                    'extension' => '.php',
                    'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
                ],

                'migration' => [
                    'filename' => function (string $type, string $name) {
                        return workbench_path('database/migrations/' . now()->format('Y_m_d') . '_000000_') . Str::snake($name) . '.php';
                    },
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:create' => [
                    'filename' => function (string $type, string $name) {
                        return workbench_path('database/migrations/0000_00_00_000000_create_') . Str::snake($name) . '_table.php';
                    },
                    'prefix' => 'Create',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'migration:foreign' => [
                    'filename' => function (string $type, string $name) {
                        return workbench_path('database/migrations/0000_00_00_100000_add_foreign_key_in_') . Str::snake($name) . '_table.php';
                    },
                    'prefix' => 'AddForeignKeyIn',
                    'suffix' => 'Table',
                    'extends' => Illuminate\Database\Migrations\Migration::class,
                ],

                'model' => [
                    'namespace' => env('STUDIO_WORKBENCH_NAMESPACE', 'Workbench\\Studio\\Package') . '\\App\\Models',
                    'path' => workbench_path('app/Models'),
                    'extension' => '.php',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                ],

            ],

        ],

        'temporary' => [

            'extends' => 'laravel',

            'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),

            'drafts' => [

                'eloquent' => [
                    'namespace' => 'Temporary\\App\\Models\\Eloquent',
                    'extension' => '.php',
                    'suffix' => 'Eloquent',
                    'extends' => Illuminate\Database\Eloquent\Model::class,
                    'traits' => [
                        Illuminate\Database\Eloquent\SoftDeletes::class,
                    ],
                ],

                'model' => [
                    'namespace' => 'Temporary\\App\\Models',
                    'extension' => '.php',
                    'nested' => [
                        'factory',
                        'eloquent',
                        'builder',
                        'migration:create',
                        'migration:foreign',
                    ],
                ],

                'builder' => [
                    'namespace' => 'Temporary\\App\\Models\\Builder',
                    'extension' => '.php',
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

                'factory' => [
                    'namespace' => 'Temporary\\Database\\Factories',
                    'extension' => '.php',
                    'suffix' => 'Factory',
                    'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
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

    ],

];
