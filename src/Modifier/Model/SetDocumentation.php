<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use DateTime;
use Dex\Laravel\Studio\Art;

class SetDocumentation
{
    public function modify(Art $art): void
    {
        $attributes = $art->draft()->attributes();

        foreach ($attributes as $attribute) {
            $type = $attribute['type'];
            $name = $attribute['name'];
            $label = $attribute['label'] ?? '';

            if (in_array($type, ['id', 'integer', 'foreignId'], true)) {
                $type = 'int';
            }

            if (in_array($type, ['uuid', 'text', 'longText', 'rememberToken'], true)) {
                $type = 'string';
            }

            if (in_array($type, ['timestamp', 'softDeletes'], true)) {
                $art->generator()
                    ->namespace()->addUse(DateTime::class);

                $type = 'DateTime';
            }

            if ($type === 'timestamps') {
                $art->generator()
                    ->namespace()->addUse(DateTime::class);

                $art->generator()
                    ->class()
                    ->addComment('@property DateTime $created_at')
                    ->addComment('@property DateTime $updated_at');

                continue;
            }

            $art->generator()
                ->class()
                ->addComment("@property $type \${$name} $label");
        }

        $relations = $art->draft()->relations();

        foreach ($relations as $relation) {
            $type = $relation['type'];

            if ($type === 'belongsTo') {
                $type = $relation['model'];
                $name = $relation['name'];
                $label = $relation['label'] ?? '';

                $class = $art->preset()->getNamespacedFor('model', $name);

                $art->generator()
                    ->namespace()
                    ->addUse($class);

                $art->generator()
                    ->class()
                    ->addComment("@property $type \${$name} $label");
            }
        }
    }
}
