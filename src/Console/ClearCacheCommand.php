<?php

namespace TallStackUi\EnvBar\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCacheCommand extends Command
{
    public $signature = 'envbar:flush-release';

    public $description = 'Flush the cache for the EnvBar releases.';

    public function handle(): int
    {
        foreach (array_keys(config('envbar.providers')) as $provider) {
            Cache::forget('envbar::'.$provider.'::release');
        }

        $this->components->info('EnvBar release cache cleared!');

        return self::SUCCESS;
    }
}
