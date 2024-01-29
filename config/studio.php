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
                'namespace' => 'Dex\\Laravel\\Studio\\Models',
                'path' => package_path('app/Models'),
            ],

        ],

        'workbench' => [

            'model' => [
                'namespace' => 'Workbench\\App\\Models',
                'path' => workbench_path('app/Models'),
            ],

        ],

    ],

];
