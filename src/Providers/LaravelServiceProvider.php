<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Providers;

use Dex\Laravel\Studio\Listeners\Factory\SetDefinition;
use Dex\Laravel\Studio\Listeners\Factory\SetModelInComments;
use Dex\Laravel\Studio\Listeners\Factory\SetModelProperty;
use Dex\Laravel\Studio\Listeners\Migration\SetColumns;
use Dex\Laravel\Studio\Listeners\Migration\SetCreateClosure;
use Dex\Laravel\Studio\Listeners\Migration\SetCreateTable;
use Dex\Laravel\Studio\Listeners\Migration\SetDownMethod;
use Dex\Laravel\Studio\Listeners\Migration\SetDropTable;
use Dex\Laravel\Studio\Listeners\Migration\SetUpMethod;
use Dex\Laravel\Studio\Listeners\SetClassName;
use Dex\Laravel\Studio\Listeners\SetExtends;
use Dex\Laravel\Studio\Listeners\SetNamespace;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class LaravelServiceProvider extends EventServiceProvider
{
    protected $listen = [

        'generate:factory' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
            SetModelInComments::class,
            SetModelProperty::class,
            SetDefinition::class,
        ],

        'generate:model' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
        ],

        'generate:migration' => [
            SetClassName::class,
            SetExtends::class,
            SetUpMethod::class,
            SetDownMethod::class,
        ],

        'generate:migration:create' => [
            SetClassName::class,
            SetExtends::class,
            SetUpMethod::class,
            SetDownMethod::class,
            SetCreateClosure::class,
            SetColumns::class,
            SetCreateTable::class,
            SetDropTable::class,
        ],

    ];
}
