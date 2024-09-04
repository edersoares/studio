<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Art\Space;

use Dex\Laravel\Studio\Art;
use Dex\Laravel\Studio\Generators\GeneratePhp;
use Dex\Laravel\Studio\Modifier\ClassNameFromPreset;
use Dex\Laravel\Studio\Modifier\ExtendsFromPreset;
use Dex\Laravel\Studio\Modifier\NamespaceFromPreset;
use Dex\Laravel\Studio\Modifier\SetStrictTypesFromPreset;

class SeederEntity extends Art
{
    use GeneratePhp;

    public function apply(): array
    {
        return [
            SetStrictTypesFromPreset::class,
            NamespaceFromPreset::class,
            ClassNameFromPreset::class,
            ExtendsFromPreset::class,
        ];
    }

    public function modify(Art $art): void
    {
        $run = $this->generator()->method('run')->setReturnType('void');

        $name = $art->draft()->name();
        $slug = $art->draft()->slug();
        $table = $art->draft()->string('table');
        $label = $art->draft()->string('label');

        $attributeModel = $art->preset()->getNamespacedFor('model', 'Attribute');
        $entityModel = $art->preset()->getNamespacedFor('model', 'Entity');
        $class = $art->preset()->getNamespacedFor('model', $name);

        $this->generator()->namespace()->addUse($attributeModel);
        $this->generator()->namespace()->addUse($entityModel);
        $this->generator()->namespace()->addUse($class);

        $attributes = $art->draft()->attributes();

        $run->addBody('$entity = Entity::query()->updateOrCreate([');
        $run->addBody('    \'slug\' => ?,', [$slug]);
        $run->addBody('], [');
        $run->addBody('    \'label\' => ?,', [$label]);
        $run->addBody('    \'table_name\' => ?,', [$table]);
        $run->addBody("    'class' => $name::class,");
        $run->addBody(']);');

        $rules = collect($attributes)
            ->filter(fn ($attribute) => $attribute['validation']['rules'] ?? false)
            ->map(fn ($attribute) => $attribute['validation']['rules'])
            ->toArray();

        foreach ($attributes as $attribute) {
            if (empty($attribute['label'])) {
                continue;
            }

            $run->addBody('');
            $run->addBody('Attribute::query()->updateOrCreate([');
            $run->addBody('    \'entity_id\' => $entity->getKey(),');
            $run->addBody('    \'slug\' => ?,', [$attribute['name']]);
            $run->addBody('], [');
            $run->addBody('    \'label\' => ?,', [$attribute['label']]);
            $run->addBody('    \'column_name\' => ?,', [$attribute['name']]);
            $run->addBody('    \'is_filterable\' => ?,', [$attribute['orion']['is_filterable'] ?? false]);
            $run->addBody('    \'is_searchable\' => ?,', [$attribute['orion']['is_searchable'] ?? false]);
            $run->addBody('    \'is_sortable\' => ?,', [$attribute['orion']['is_sortable'] ?? false]);
            $run->addBody('    \'is_includable\' => ?,', [$attribute['orion']['is_includable'] ?? false]);
            $run->addBody('    \'is_relation\' => ?,', [$attribute['orion']['is_relation'] ?? false]);
            $run->addBody('    \'is_visible\' => ?,', [!($attribute['hidden'] ?? false)]);
            $run->addBody('    \'rules\' => ?,', [$rules[$attribute['name']] ?? []]);
            $run->addBody(']);');
        }
    }
}
