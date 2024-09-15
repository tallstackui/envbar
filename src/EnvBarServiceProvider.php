<?php

namespace TallStackUi\EnvBar;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use TallStackUi\EnvBar\Middleware\Injection;

class EnvBarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'envbar');

        $this->mergeConfigFrom(__DIR__.'/../config/envbar.php', 'envbar');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'envbar');

        $this->app[Kernel::class]->appendMiddlewareToGroup('web', Injection::class);
    }
}
