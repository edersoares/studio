<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Blueprint;

test('`drafts` method', function () {
    $blueprint = new Blueprint([
        'drafts' => [
            'user' => [
                'type' => 'model',
                'name' => 'User',
            ],
        ],
    ]);

    expect($blueprint->drafts())->toBe([
        'user' => [
            'type' => 'model',
            'name' => 'User',
        ],
    ]);
});
