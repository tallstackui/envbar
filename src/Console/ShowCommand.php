<?php

namespace TallStackUi\EnvBar\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ShowCommand extends Command
{
    public $signature = 'envbar:show';

    public $description = 'Show the EnvBar again regardless of the close timeout.';

    public function handle(): int
    {
        Cache::put('envbar::show', true);

        $this->components->info('EnvBar will be shown again. Refresh the browser!');

        return self::SUCCESS;
    }
}
