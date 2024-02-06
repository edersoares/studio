<?php

namespace Dex\Laravel\Studio\Listeners\Factory;

use Dex\Laravel\Studio\Blueprint\Blueprint;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\Generator;

class SetDefinition
{
    public function __invoke(Generator $generator, Draft $draft, Blueprint $blueprint, Preset $preset): void
    {$method = $generator->class()
        ->addMethod('definition')
        ->addBody('return [');

        $definition = $draft->get('attributes', []);

        foreach ($definition as $attribute => $options) {
            if (str_starts_with($options['factory'] ?? '', 'faker:')) {
                $faker = explode(':', $options['factory']);

                array_shift($faker);

                $name = array_shift($faker);

                $method->addBody('    \'' . $attribute . '\' => $this->faker->' . $name . '(...?),', [$faker]);
            }

            if (str_starts_with($options['factory'] ?? '', 'model:')) {
                $faker = explode(':', $options['factory']);

                array_shift($faker);

                $model = array_shift($faker);

                $namespacedModel = $preset->getNamespacedFor('model', $model);
                $generator->namespace()->addUse($namespacedModel);

                $method->addBody('    \'' . $attribute . '\' => fn () => ' . $model . '::factory()->create(),');
            }
        }

        $method->addBody('];');
    }
}
