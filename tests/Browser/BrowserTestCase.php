<?php

namespace Tests\Browser;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use TallStackUi\EnvBar\EnvBarServiceProvider;

class BrowserTestCase extends TestCase
{
    protected $loadEnvironmentVariables = false;

    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config) {
            $config->set('app.env', 'testing');
            $config->set('app.debug', true);
            $config->set('view.paths', [__DIR__.'/views', resource_path('views')]);
            $config->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
            $config->set('cache.default', 'array');
            $config->set('envbar.disable_on_tests', false);
            $config->set('envbar.environments', '*');
        });
    }

    protected function defineWebRoutes($router): void
    {
        $router->view('/', 'welcome')->name('welcome');
    }

    protected function getPackageProviders($app): array
    {
        return [EnvBarServiceProvider::class];
    }

    protected function setUp(): void
    {
        if (isset($_SERVER['CI'])) {
            Options::withoutUI();
        }

        $this->afterApplicationCreated(function () {
            Artisan::call('view:clear');
        });

        $this->beforeApplicationDestroyed(function () {
            Artisan::call('view:clear');
        });

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->removeApplicationTweaks();

        if (! $this->status()->isSuccess()) {
            $this->captureFailuresFor(collect(static::$browsers));
            $this->storeSourceLogsFor(collect(static::$browsers));
        }

        $this->closeAll();

        parent::tearDown();
    }
}
