<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Illuminate\Console\Command;

class StudioCommand extends Command
{
    protected $signature = 'studio';

    protected $description = 'Studio for Artisans';

    public function handle(): int
    {
        $this->comment('Studio for Artisans');

        return self::SUCCESS;
    }
}
