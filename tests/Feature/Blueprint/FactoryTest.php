<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Blueprint\Factory;

test('model', fn () => expect(Factory::generate('model', 'User'))->toMatchSnapshot());
test('factory', fn () => expect(Factory::generate('factory', 'UserFactory'))->toMatchSnapshot());
test('migration', fn () => expect(Factory::generate('migration', 'UserMigration'))->toMatchSnapshot());
test('migration:create', fn () => expect(Factory::generate('migration:create', 'User'))->toMatchSnapshot());
test('migration:foreign', fn () => expect(Factory::generate('migration:foreign', 'User'))->toMatchSnapshot());
test('eloquent', fn () => expect(Factory::generate('eloquent', 'UserEloquent'))->toMatchSnapshot());
test('builder', fn () => expect(Factory::generate('builder', 'UserBuilder'))->toMatchSnapshot());
