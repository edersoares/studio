<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;

test('`drafts` method', function () {
    $blueprint = new Blueprint([
        'drafts' => [
            'user' => [
                'type' => 'model',
                'name' => 'User',
            ],
        ],
    ]);

    expect($blueprint->drafts())->toContainOnlyInstancesOf(Draft::class);
});
