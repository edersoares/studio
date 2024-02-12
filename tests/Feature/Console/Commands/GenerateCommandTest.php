<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;

use function Pest\Laravel\artisan;

test('`generate` command exists')
    ->artisan('generate model User')
    ->assertOk();

test('`generate` command dispatch a event', function () {
    Event::fake();

    artisan('generate model User');

    Event::assertDispatched('generate:model');
});

test('`generate` dump generated content', function () {
    artisan('generate', [
        'type' => 'model',
        'name' => 'User',
        '--dump' => true,
    ])->expectsOutputToContain('class User extends Model');
});

test('`generate` command create file', function () {
    artisan('generate', [
        'type' => 'model',
        'name' => 'User',
        '--preset' => 'temporary',
        '--file' => true,
    ])->assertOk();
});
