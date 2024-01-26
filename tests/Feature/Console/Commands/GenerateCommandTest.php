<?php

declare(strict_types=1);

test('`generate` command exists')
    ->artisan('generate model User')
    ->expectsOutput('Generate new files')
    ->assertOk();
