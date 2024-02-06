<?php

declare(strict_types=1);

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
                'extends' => \Illuminate\Database\Eloquent\Model::class,
                'traits' => [
                    \Illuminate\Database\Eloquent\SoftDeletes::class,
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
                ],
            ],

            'builder' => [
                'namespace' => 'Workbench\\App\\Models\\Builder',
                'path' => workbench_path('app/Models/Builder'),
                'extension' => '.php',
                'suffix' => 'Builder',
                'extends' => \Illuminate\Database\Eloquent\Builder::class,
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
                'extends' => \Illuminate\Database\Eloquent\Factories\Factory::class,
            ],

        ],

    ],

];
