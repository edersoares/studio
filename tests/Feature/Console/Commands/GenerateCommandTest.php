<?php

declare(strict_types=1);

test('`generate` command exists')
    ->artisan('generate model User')
    ->expectsOutput('Generate new files')
    ->assertOk();

test('`generate` command expects a `type` and a `name`')
    ->artisan('generate')
    ->expectsChoice('What type of file would you generate?', 'model', ['model'])
    ->expectsQuestion('What name?', 'User')
    ->expectsOutput('Generate new files')
    ->assertOk();
