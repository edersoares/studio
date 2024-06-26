<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Providers;

use Dex\Laravel\Studio\Listeners\Eloquent\SetCustomBuilder;
use Dex\Laravel\Studio\Listeners\Eloquent\SetDocumentation;
use Dex\Laravel\Studio\Listeners\Eloquent\SetFillableProperty;
use Dex\Laravel\Studio\Listeners\Eloquent\SetRelations;
use Dex\Laravel\Studio\Listeners\Eloquent\SetTableProperty;
use Dex\Laravel\Studio\Listeners\Factory\SetDefinition;
use Dex\Laravel\Studio\Listeners\Factory\SetModelInComments;
use Dex\Laravel\Studio\Listeners\Factory\SetModelProperty;
use Dex\Laravel\Studio\Listeners\Migration\SetColumns;
use Dex\Laravel\Studio\Listeners\Migration\SetCreateClosure;
use Dex\Laravel\Studio\Listeners\Migration\SetCreateTable;
use Dex\Laravel\Studio\Listeners\Migration\SetDownAlterTable;
use Dex\Laravel\Studio\Listeners\Migration\SetDownClosure;
use Dex\Laravel\Studio\Listeners\Migration\SetDownMethod;
use Dex\Laravel\Studio\Listeners\Migration\SetDropForeignKeys;
use Dex\Laravel\Studio\Listeners\Migration\SetDropTable;
use Dex\Laravel\Studio\Listeners\Migration\SetForeignKeys;
use Dex\Laravel\Studio\Listeners\Migration\SetUpAlterTable;
use Dex\Laravel\Studio\Listeners\Migration\SetUpClosure;
use Dex\Laravel\Studio\Listeners\Migration\SetUpMethod;
use Dex\Laravel\Studio\Listeners\Model\DefineContextOptionsForModel;
use Dex\Laravel\Studio\Listeners\SetClassName;
use Dex\Laravel\Studio\Listeners\SetExtends;
use Dex\Laravel\Studio\Listeners\SetNamespace;
use Dex\Laravel\Studio\Listeners\SetTraits;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class LaravelServiceProvider extends EventServiceProvider
{
    protected $listen = [

        'generate:builder' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
        ],

        'generate:controller' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
        ],

        'generate:eloquent' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
            SetTraits::class,
            SetDocumentation::class,
            SetTableProperty::class,
            SetFillableProperty::class,
            SetRelations::class,
            SetCustomBuilder::class,
        ],

        'generate:factory' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
            SetModelInComments::class,
            SetModelProperty::class,
            SetDefinition::class,
        ],

        'generate:model' => [
            DefineContextOptionsForModel::class,
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

        'generate:migration:foreign' => [
            SetClassName::class,
            SetExtends::class,
            SetUpMethod::class,
            SetDownMethod::class,
            SetUpClosure::class,
            SetDownClosure::class,
            SetForeignKeys::class,
            SetDropForeignKeys::class,
            SetUpAlterTable::class,
            SetDownAlterTable::class,
        ],

        'generate:policy' => [
            SetNamespace::class,
            SetClassName::class,
            SetExtends::class,
        ],

    ];
}
