<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Modifier\Model;

use DateTime;
use Dex\Laravel\Studio\Art;
use Illuminate\Database\Eloquent\Collection;

class SetDocumentation
{
    public function modify(Art $art): void
    {
        $attributes = $art->draft()->attributes();

        foreach ($attributes as $attribute) {
            $type = $attribute['type'];
            $name = $attribute['name'];
            $label = $attribute['label'] ?? '';

            if ($type === 'boolean') {
                $type = 'bool';
            }

            if (in_array($type, ['integer', 'id', 'foreignId'], true)) {
                $type = 'int';
            }

            if (in_array($type, ['uuid', 'text', 'longText', 'rememberToken'], true)) {
                $type = 'string';
            }

            if ($type === 'json') {
                $type = 'array';
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

            if (in_array($type, ['timestamp', 'softDeletes'], true)) {
                $type = 'DateTime';

                $art->generator()
                    ->namespace()->addUse(DateTime::class);
            }

            $art->generator()
                ->class()
                ->addComment("@property $type \${$name} $label");
        }

        $relations = $art->draft()->relations();

        if ($relations) {
            $art->generator()
                ->class()
                ->addComment('');
        }

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

            if ($type === 'hasMany') {
                $type = $relation['model'];
                $name = $relation['name'];
                $label = $relation['label'] ?? '';

                $class = $art->preset()->getNamespacedFor('model', $name);

                $art->generator()
                    ->namespace()
                    ->addUse($class)
                    ->addUse(Collection::class);

                $art->generator()
                    ->class()
                    ->addComment("@property Collection<int, $type> \${$name} $label");
            }
        }
    }
}
