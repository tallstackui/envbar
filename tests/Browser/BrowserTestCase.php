<?php

namespace Tests\Browser;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Laravel\Dusk\Browser;
use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use TallStackUi\EnvBar\EnvBarServiceProvider;

class BrowserTestCase extends TestCase
{
    public static function tmpPath(string $path = ''): string
    {
        return __DIR__."/tmp/{$path}";
    }

    public static function tweakApplicationHook(): Closure
    {
        return function () {};
    }

    protected function defineEnvironment($app): void
    {
        tap($app['session'], function ($session) {
            $session->put('_token', str()->random(40));
        });

        tap($app['config'], function (Repository $config) {
            $config->set('app.env', 'testing');
            $config->set('app.debug', true);
            $config->set('view.paths', [__DIR__.'/views', resource_path('views')]);
            $config->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
            $config->set('filesystems.disks.tmp-for-tests', [
                'driver' => 'local',
                'root' => self::tmpPath(),
            ]);
            $config->set('cache.default', 'array');
        });
    }

    protected function getApplicationTimezone($app): string
    {
        return (bool) getenv('GITHUB_ACTIONS') === false ? 'America/Sao_Paulo' : $app['config']['app.timezone'];
    }

    protected function getPackageProviders($app): array
    {
        return [
            EnvBarServiceProvider::class,
        ];
    }

    protected function livewireClassesPath($path = ''): string
    {
        return app_path('Livewire'.($path ? '/'.$path : ''));
    }

    protected function livewireTestsPath($path = ''): string
    {
        return base_path('tests/Feature/Livewire'.($path ? '/'.$path : ''));
    }

    protected function livewireViewsPath($path = ''): string
    {
        return resource_path('views').'/livewire'.($path ? '/'.$path : '');
    }

    protected function makeACleanSlate(): void
    {
        Artisan::call('view:clear');

        File::deleteDirectory(self::tmpPath());

        File::ensureDirectoryExists(self::tmpPath());
    }

    protected function paused(int $seconds = 3): int
    {
        return 1000 * $seconds;
    }

    protected function setUp(): void
    {
        if (isset($_SERVER['CI'])) {
            Options::withoutUI();
        }

        Browser::$waitSeconds = 7;

        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();
    }

    protected function skipOnGitHubActions(?string $message = null): void
    {
        if ((bool) getenv('GITHUB_ACTIONS') === false) {
            return;
        }

        $this->markTestSkipped($message ?? 'For some unknown reason this test fails on GitHub Actions.');
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
