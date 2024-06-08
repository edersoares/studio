<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('model', fn () => expect(Factory::make('model', 'User'))->toMatchSnapshot());
test('factory', fn () => expect(Factory::make('factory', 'UserFactory'))->toMatchSnapshot());
test('migration', fn () => expect(Factory::make('migration', 'UserMigration'))->toMatchSnapshot());
test('migration:create', fn () => expect(Factory::make('migration:create', 'User'))->toMatchSnapshot());
test('migration:foreign', fn () => expect(Factory::make('migration:foreign', 'User'))->toMatchSnapshot());
test('eloquent', fn () => expect(Factory::make('eloquent', 'UserEloquent'))->toMatchSnapshot());
test('builder', fn () => expect(Factory::make('builder', 'UserBuilder'))->toMatchSnapshot());
