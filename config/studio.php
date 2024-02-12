<?php

declare(strict_types=1);

use Illuminate\Support\Str;

use function Orchestra\Testbench\package_path;
use function Orchestra\Testbench\workbench_path;

return [

    'preset' => env('STUDIO_PRESET', 'workbench'),

    'presets' => [

        'laravel' => [

            'model' => [
                'namespace' => 'App\\Models',
                'path' => base_path('app/Models'),
            ],

        ],

        'package' => [

            'model' => [
                'namespace' => env('STUDIO_NAMESPACE', ''),
                'path' => package_path('app/Models'),
            ],

        ],

        'workbench' => [

            'eloquent' => [
                'namespace' => 'Workbench\\App\\Models\\Eloquent',
                'path' => workbench_path('app/Models/Eloquent'),
                'extension' => '.php',
                'suffix' => 'Eloquent',
                'extends' => Illuminate\Database\Eloquent\Model::class,
                'traits' => [
                    Illuminate\Database\Eloquent\SoftDeletes::class,
                ],
            ],

            'model' => [
                'namespace' => 'Workbench\\App\\Models',
                'path' => workbench_path('app/Models'),
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
                'namespace' => 'Workbench\\App\\Models\\Builder',
                'path' => workbench_path('app/Models/Builder'),
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
                'namespace' => 'Workbench\\Database\\Factories',
                'path' => workbench_path('database/factories'),
                'extension' => '.php',
                'suffix' => 'Factory',
                'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
            ],

            'migration:create' => [
                'filename' => function (string $type, string $name) {
                    return base_path('packages/dex/addressing/database/migrations/0000_00_00_000000_create_') . Str::snake($name) . '_table.php';
                },
                'prefix' => 'Create',
                'suffix' => 'Table',
                'extends' => Illuminate\Database\Migrations\Migration::class,
            ],

            'migration:foreign' => [
                'filename' => function (string $type, string $name) {
                    return base_path('packages/dex/addressing/database/migrations/0000_00_00_100000_add_foreign_key_in_') . Str::snake($name) . '_table.php';
                },
                'prefix' => 'AddForeignKeyIn',
                'suffix' => 'Table',
                'extends' => Illuminate\Database\Migrations\Migration::class,
            ],

        ],

        'temporary' => [

            'eloquent' => [
                'namespace' => 'Temporary\\App\\Models\\Eloquent',
                'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),
                'extension' => '.php',
                'suffix' => 'Eloquent',
                'extends' => Illuminate\Database\Eloquent\Model::class,
                'traits' => [
                    Illuminate\Database\Eloquent\SoftDeletes::class,
                ],
            ],

            'model' => [
                'namespace' => 'Temporary\\App\\Models',
                'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),
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
                'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),
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
                'path' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),
                'extension' => '.php',
                'suffix' => 'Factory',
                'extends' => Illuminate\Database\Eloquent\Factories\Factory::class,
            ],

            'migration:create' => [
                'filename' => function (string $type, string $name) {
                    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . '0000_00_00_000000_create_' . Str::snake($name) . '_table.php';
                },
                'prefix' => 'Create',
                'suffix' => 'Table',
                'extends' => Illuminate\Database\Migrations\Migration::class,
            ],

            'migration:foreign' => [
                'filename' => function (string $type, string $name) {
                    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . '0000_00_00_100000_add_foreign_key_in_' . Str::snake($name) . '_table.php';
                },
                'prefix' => 'AddForeignKeyIn',
                'suffix' => 'Table',
                'extends' => Illuminate\Database\Migrations\Migration::class,
            ],

        ],

    ],

];
