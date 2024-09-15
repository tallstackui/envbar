<?php

namespace TallStackUi\EnvBar;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use TallStackUi\EnvBar\Middleware\Injection;

class EnvBarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfiguration();

        $this->registerMiddleware();

        if ($this->app->runningInConsole()) {
            $this->registerAssetTag();
            $this->registerCommands();
        }
    }

    private function registerConfiguration(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'envbar');
        $this->mergeConfigFrom(__DIR__.'/../config/envbar.php', 'envbar');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'envbar');
    }

    private function registerMiddleware(): void
    {
        $this->app[Kernel::class]->pushMiddleware(Injection::class);
    }

    private function registerAssetTag(): void
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path(),
        ], 'assets');
    }

    private function registerCommands(): void
    {
        $this->commands(Console\PublishCommand::class);
    }
}
