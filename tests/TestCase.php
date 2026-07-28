<?php

namespace Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithViews;
    use WithWorkbench;

    protected function defineEnvironment($app): void
    {
        tap($app['config'], function (Repository $config): void {
            $config->set('cache.default', 'array');
            $config->set('envbar.disable_on_tests', false);
            $config->set('envbar.environments', '*');
        });
    }
}
