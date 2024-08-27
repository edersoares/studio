<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Draft;

return [

    'preset' => 'studio',

    'drafts' => [

        Draft::new('User')
            ->set('table', 'user')
            ->attribute()->id()
            ->attribute()->string('name')->fillable()->required()->min(3)->max(50)->faker('name')
            ->attribute()->string('email')->unique()->fillable()->required()->min(3)->faker('email')
            ->attribute()->timestamp('email_verified_at')->nullable()->cast('datetime')
            ->attribute()->string('password')->fillable()->hidden()->cast('hashed')->required()->min(8)->max(48)->faker('lexify', '########')
            ->attribute()->rememberToken()->hidden()
            ->attribute()->timestamps()
            ->relation()->belongsTo('Group')
            ->relation()->hasMany('Role')
            ->relation()->hasOne('Role')
            ->draft()
            ->push('generate', 'model')
            ->push('generate', 'migration:create')
            ->push('generate', 'factory')
            ->push('generate', 'controller')
            ->push('generate', 'request')
            ->push('generate', 'tester')
            ->data(),

        Draft::new('PasswordResetTokens')
            ->set('table', 'password_reset_tokens')
            ->attribute()->string('email')->primary()
            ->attribute()->string('token')
            ->attribute()->timestamp('created_at')->nullable()
            ->draft()
            ->push('generate', 'migration:create')
            ->data(),

        Draft::new('Sessions')
            ->set('table', 'sessions')
            ->attribute()->string('id')->primary()
            ->attribute()->foreign('user_id')->nullable()->index()
            ->attribute()->string('ip_address', 45)->nullable()
            ->attribute()->text('user_agent')->nullable()
            ->attribute()->longText('payload')
            ->attribute()->integer('last_activity')->index()
            ->draft()
            ->push('generate', 'migration:create')
            ->data(),

    ],

];
