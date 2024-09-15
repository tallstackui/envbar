<?php

namespace TallStackUi\EnvBar;

use Carbon\Laravel\ServiceProvider;

class EnvBarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfiguration();
    }

    private function registerConfiguration(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'envbar');
        $this->mergeConfigFrom(__DIR__.'/../config/envbar.php', 'envbar');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'envbar');
    }
}
