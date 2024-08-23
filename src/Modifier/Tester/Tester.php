<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Tester;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Nette\PhpGenerator\Closure;

class Tester
{
    protected Art $art;

    public function modify(Art $art): void
    {
        /** @var PhpGenerator $generator */
        $generator = $art->generator();

        $name = $art->draft()->name();
        $namespaced = $art->preset()->getNamespacedFor('model', $name);

        $generator->file()->setStrictTypes();
        $generator->namespace()->addUse($namespaced);

        $describe = new Closure();

        $describe->addBody("beforeEach()->eloquent($name::class);");
        $describe->addBody('');

        $methods = [
            'toBeCreate' => [],
            'toBeUpdate' => [],
            'toBeDelete' => [],
        ];

        foreach ($methods as $method => $params) {
            $describe->addBody("test()->$method(...?);", [$params]);
        }

        $relations = $art->draft()->relations();

        foreach ($relations as $relation => $options) {
            $relationModel = $options['model'];
            $relationNamespaced = $art->preset()->getNamespacedFor('model', $relationModel);

            $generator->namespace()->addUse($relationNamespaced);

            if ($options['type'] === 'belongsTo') {
                $describe->addBody("test()->toHaveBelongsToRelation($relationModel::class, ?);", [$relation]);
            }

            if ($options['type'] === 'hasOne') {
                $describe->addBody("test()->toHaveHasOneRelation($relationModel::class, ?);", [$relation]); // @codeCoverageIgnore
            }

            if ($options['type'] === 'hasMany') {
                $describe->addBody("test()->toHaveHasManyRelation($relationModel::class, ?);", [$relation]);
            }
        }

        $describe->addBody('');
        $describe->addBody('beforeEach()->endpoint(?);', ['/' . $art->draft()->slug()]);
        $describe->addBody('');

        $methods = [
            'toHaveIndexEndpoint' => [],
            'toHaveShowEndpoint' => [],
            'toHaveStoreEndpoint' => [],
            'toHaveUpdateEndpoint' => [],
            'toHaveDestroyEndpoint' => [],
        ];

        foreach ($methods as $method => $params) {
            $describe->addBody("test()->$method(...?);", [$params]);
        }

        foreach ($art->draft()->attributes() as $attribute => $data) {
            if ($data['validation']['rules'] ?? false) {
                foreach ($data['validation']['rules'] as $rule) {
                    if ($rule === 'required') {
                        $describe->addBody('test()->toValidateRequired(...?);', [[$attribute]]);
                    }

                    if (str_starts_with($rule, 'min')) {
                        [, $min] = explode(':', $rule);
                        $describe->addBody('test()->toValidateMin(...?);', [[$attribute, intval($min)]]);
                    }

                    if (str_starts_with($rule, 'max')) {
                        [, $max] = explode(':', $rule);
                        $describe->addBody('test()->toValidateMax(...?);', [[$attribute, intval($max)]]);
                    }

                    if (str_starts_with($rule, 'size')) {
                        [, $size] = explode(':', $rule);  // @codeCoverageIgnore
                        $describe->addBody('test()->toValidateSize(...?);', [[$attribute, intval($size)]]);  // @codeCoverageIgnore
                    }
                }
            }
        }

        $printed = $generator->printer()->printClosure($describe);

        $body = "describe($name::class, $printed);";

        $generator->body($body);
    }
}
