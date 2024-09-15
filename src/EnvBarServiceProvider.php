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
    }

    private function registerConfigurations(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'envbar');

        $this->mergeConfigFrom(__DIR__.'/../config/envbar.php', 'envbar');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'envbar');
    }

    private function registerMiddleware(): void
    {
        $this->app[Kernel::class]->appendMiddlewareToGroup('web', Injection::class);
    }

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
}
