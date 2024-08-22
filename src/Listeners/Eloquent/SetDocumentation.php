<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Listeners\Eloquent;

use DateTime;
use Dex\Laravel\Studio\Blueprint\Draft;
use Dex\Laravel\Studio\Blueprint\Preset;
use Dex\Laravel\Studio\Generators\PhpGenerator;
use Illuminate\Database\Eloquent\Collection;

/**
 * @codeCoverageIgnore
 */
class SetDocumentation
{
    public function __invoke(PhpGenerator $generator, Draft $draft, Preset $preset): void
    {
        $comments = [];

        $attributes = $draft->array('attributes');

        foreach ($attributes as $attribute => $options) {
            $type = $options['type'];

            if (in_array($type, ['id', 'foreignId', 'integer'], true)) {
                $type = 'int';
            }

            if ($type === 'timestamps') {
                $generator->namespace()->addUse(DateTime::class);
                $comments[] = '@property DateTime $created_at';
                $comments[] = '@property DateTime $updated_at';

                continue;
            }

            if ($type === 'softDeletes') {
                $generator->namespace()->addUse(DateTime::class);
                $comments[] = '@property DateTime $deleted_at';

                continue;
            }

            $comments[] = "@property $type \$$attribute";
        }

        $relations = $draft->array('relations');

        foreach ($relations as $relation => $options) {
            $type = $options['type'];

            $model = $preset->getNameFor('model', $options['model']);
            $namespacedModel = $preset->getNamespacedFor('model', $options['model']);

            if ($type === 'belongsTo') {
                $generator->namespace()->addUse($namespacedModel);
                $comments[] = "@property $model \$$relation";
            }

            if ($type === 'hasMany') {
                $generator->namespace()->addUse(Collection::class);
                $generator->namespace()->addUse($namespacedModel);
                $comments[] = "@property Collection<int, $model> \$$relation";
            }
        }

        $comments[] = '';

        foreach ($comments as $comment) {
            if (str_contains((string) $generator->class()->getComment(), $comment)) {
                return;
            }

            $generator->class()->addComment($comment);
        }
    }
}
