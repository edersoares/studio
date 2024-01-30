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
                'suffix' => 'Eloquent',
            ],

            'model' => [
                'namespace' => 'Workbench\\App\\Models',
                'path' => workbench_path('app/Models'),
            ],

            'builder' => [
                'namespace' => 'Workbench\\App\\Models\\Builder',
                'path' => workbench_path('app/Models/Builder'),
                'suffix' => 'Builder',
            ],

        ],

    ],

];
