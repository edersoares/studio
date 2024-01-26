<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Models\Studio;

test('command exists', function () {
    $this->artisan('studio')
        ->expectsOutput('Studio for Artisans')
        ->assertSuccessful();
});

test('route exists', function () {
    $this->get('studio')
        ->assertSee('Studio for Artisans')
        ->assertOk();
});

test('database table is empty', function () {
    $this->assertDatabaseEmpty(Studio::class);
});
