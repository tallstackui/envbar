<?php

namespace TallStackUi\EnvBar\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    public $signature = 'envbar:publish';

    public $description = 'Publish the assets for the TallStackUi EnvBar package';

    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--force' => true,
            '--tag' => 'assets',
            '--provider' => 'TallStackUi\EnvBar\EnvBarServiceProvider',
        ]);

        return self::SUCCESS;
    }
}
