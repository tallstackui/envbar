<?php

namespace TallStackUi\EnvBar;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\View\Compilers\BladeCompiler;
use TallStackUi\EnvBar\Middleware\Injection;

class EnvBarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfigurations();

        $this->registerMiddleware();

        $this->registerComponents();

        $this->registerCommands();
    }

    /**
     * Register the EnvBar configuration stuffs.
     */
    private function registerConfigurations(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'envbar');

        $this->mergeConfigFrom(__DIR__.'/../config/envbar.php', 'envbar');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'envbar');

        $this->publishes([
            __DIR__.'/../config/envbar.php' => config_path('envbar.php'),
        ], 'envbar-config');
    }

    /**
     * Register the EnvBar middleware.
     */
    private function registerMiddleware(): void
    {
        $this->app[Kernel::class]->appendMiddlewareToGroup('web', Injection::class);
    }

    /**
     * Register the EnvBar components.
     */
    private function registerComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade): void {
            foreach ([
                'envbar::badge' => View\Components\Badge::class,
            ] as $name => $class) {
                $blade->component($class, $name);
            }
        });
    }

    /**
     * Register the EnvBar commands.
     */
    public function registerCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(Console\ClearCacheCommand::class);
    }
}
