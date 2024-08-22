<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Factory;

use Dex\Laravel\Studio\Art;

class SetDefinitionMethod
{
    public function modify(Art $art): void
    {
        $method = $art->generator()
            ->method('definition')
            ->setReturnType('array')
            ->addBody('return [');

        $definition = $art->draft()->attributes();

        foreach ($definition as $attribute => $options) {
            if (empty($options['factory'])) {
                continue;
            }

            $this->faker($art, $attribute, $options);
            $this->model($art, $attribute, $options);
        }

        $method->addBody('];');
    }

    protected function faker($art, $attribute, $options): void
    {
        if (array_key_exists('faker', $options['factory']) === false) {
            return;
        }

        $faker = $options['factory']['faker'];

        $name = array_shift($faker);

        $art->generator()
            ->method('definition')
            ->addBody('    \'' . $attribute . '\' => $this->faker->' . $name . '(...?),', [$faker]);
    }

    protected function model($art, $attribute, $options): void
    {
        if (array_key_exists('model', $options['factory']) === false) {
            return;
        }

        $faker = $options['factory']['model'];

        /** @var string $model */
        $model = array_shift($faker);

        $namespacedModel = $art->preset()->getNamespacedFor('model', $model);
        $art->generator()->namespace()->addUse($namespacedModel);

        $art->generator()
            ->method('definition')
            ->addBody('    \'' . $attribute . '\' => fn () => ' . $model . '::factory()->create(),');
    }
}
