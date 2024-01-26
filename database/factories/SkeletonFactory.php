<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Database\Factories;

use Dex\Laravel\Studio\Models\Studio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Studio>
 */
class SkeletonFactory extends Factory
{
    protected $model = Studio::class;

    public function definition(): array
    {
        return [

        ];
    }
}
