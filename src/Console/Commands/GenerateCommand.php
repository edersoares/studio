<?php

declare(strict_types=1);

namespace Dex\Laravel\Studio\Console\Commands;

use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    protected $signature = 'generate {arguments?*} {--preset=}';

    protected $description = 'Generate new files';

    public function handle(): int
    {
        $this->comment('Generate new files');

        return self::SUCCESS;
    }
}
