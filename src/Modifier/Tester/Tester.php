<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Tester;

use Dex\Laravel\Studio\Art;
use Dex\Pest\Plugin\Laravel\Tester\Tester as PestTester;
use Nette\PhpGenerator\Closure;

class Tester
{
    protected Art $art;

    public function modify(Art $art): void
    {
        $name = $art->draft()->name();
        $namespaced = $art->preset()->getNamespacedFor('model', $name);

        $art->generator()->file()->setStrictTypes();
        $art->generator()->namespace()->addUse($namespaced);
        $art->generator()->namespace()->addUse(PestTester::class);

        $describe = new Closure();

        $this->addEloquentTests($art, $describe);
        $this->addRelationsTests($art, $describe);
        $this->addEndpointTests($art, $describe);
        $this->addValidatorTests($art, $describe);

        $printed = $art->generator()->printer()->printClosure($describe);

        $body = [];

        $body[] = 'uses(Tester::class);';
        $body[] = '';
        $body[] = "describe($name::class, $printed);";
        $body[] = '';

        $art->generator()->body(implode("\n", $body));
    }

    protected function addEloquentTests(Art $art, Closure $describe): void
    {
        $name = $art->draft()->name();

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
    }

    protected function addRelationsTests(Art $art, Closure $describe): void
    {
        $relations = $art->draft()->relations();

        foreach ($relations as $relation => $options) {
            $relationModel = $options['model'];
            $relationNamespaced = $art->preset()->getNamespacedFor('model', $relationModel);

            $art->generator()->namespace()->addUse($relationNamespaced);

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
    }

    protected function addEndpointTests(Art $art, Closure $describe): void
    {
        $endpoint = $art->draft()->string('endpoint');

        if (empty($endpoint)) {
            return;
        }

        $seeder = $art->preset()->getNameFor('seeder:entity', $art->draft()->name());
        $seederNamespaced = $art->preset()->getNamespacedFor('seeder:entity', $art->draft()->name());

        $art->generator()->namespace()->addUse($seederNamespaced);

        $describe->addBody('');
        $describe->addBody('beforeEach()->endpoint(?);', [$endpoint]);
        $describe->addBody('beforeEach()->wrap(\'data\');');
        $describe->addBody("beforeEach()->seed($seeder::class);");
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
    }

    protected function addValidatorTests(Art $art, Closure $describe): void
    {
        $endpoint = $art->draft()->string('endpoint');

        if (empty($endpoint)) {
            return;
        }

        $describe->addBody('');

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
    }
}
