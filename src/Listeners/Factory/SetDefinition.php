<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;

class SetDefinition
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {
        $method = $generator->method('definition')
            ->setReturnType('array')
            ->setBody('return [');

        $definition = $draft->array('attributes');

        foreach ($definition as $attribute => $options) {
            if (empty($options['factory'])) {
                continue;
            }

            if (array_key_exists('faker', $options['factory'])) {
                $faker = $options['factory']['faker'];

                $name = array_shift($faker);

                $method->addBody('    \'' . $attribute . '\' => $this->faker->' . $name . '(...?),', [$faker]);
            }

            if (array_key_exists('model', $options['factory'])) {
                $faker = $options['factory']['model'];

                /** @var string $model */
                $model = array_shift($faker);

                $namespacedModel = $preset->getNamespacedFor('model', $model);
                $generator->namespace()->addUse($namespacedModel);

                $method->addBody('    \'' . $attribute . '\' => fn () => ' . $model . '::factory()->create(),');
            }
        }

        $method->addBody('];');
    }
}
