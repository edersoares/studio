<?php

declare(strict_types=1);

return [

    'preset' => 'studio',

    'drafts' => [

        draft('User')
            ->set('table', 'user')
            ->attribute()->label('ID')->id()
            ->attribute()->label('Nome')->string('name')->fillable()->required()->min(3)->max(50)->faker('name')
            ->attribute()->label('E-mail')->string('email')->unique()->fillable()->required()->email()->min(3)->faker('email')
            ->attribute()->label('E-mail verificado')->timestamp('email_verified_at')->nullable()->cast('datetime')
            ->attribute()->label('Senha')->string('password')->fillable()->hidden()->cast('hashed')->required()->confirmed()->min(8)->max(48)->faker('lexify', '########')
            ->attribute()->rememberToken()->hidden()
            ->attribute()->timestamps()
            ->relation()->hasMany('Profile')
            ->relation()->hasOne('Profile')
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->push('generate', 'factory')
            ->push('generate', 'controller')
            ->push('generate', 'request')
            ->push('generate', 'tester')
            ->data(),

        draft('Profile')
            ->set('table', 'profile')
            ->attribute()->uuid('id')->primary()
            ->attribute()->foreign('user_id')->factory('User')
            ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('name')
            ->attribute()->timestamps()
            ->relation()->belongsTo('User')
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'factory')
            ->push('generate', 'migration:create')
            ->push('generate', 'tester')
            ->data(),

        draft('PasswordResetTokens')
            ->set('table', 'password_reset_tokens')
            ->attribute()->string('email')->primary()
            ->attribute()->string('token')
            ->attribute()->timestamp('created_at')->nullable()
            ->draft()
            ->push('generate', 'migration:create')
            ->data(),

        draft('Sessions')
            ->set('table', 'sessions')
            ->attribute()->string('id')->primary()
            ->attribute()->foreign('user_id')->nullable()->index()
            ->attribute()->string('ip_address', 45)->nullable()
            ->attribute()->text('user_agent')->nullable()
            ->attribute()->longText('payload')
            ->attribute()->integer('last_activity')->index()
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->data(),

    ],

];
