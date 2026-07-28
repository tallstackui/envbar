<?php

namespace Tests\Browser\EnvBar;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\Browser\BrowserTestCase;

class GitHubProviderTest extends BrowserTestCase
{
    #[Test]
    public function see_release(): void
    {
        $this->beforeServingApplication(function ($app, Repository $config): void {
            Cache::shouldReceive('has')->andReturnTrue();
            Cache::shouldReceive('get')->andReturn('v1.0.0');
            Cache::shouldReceive('pull')->andReturnNull();

            $config->set('envbar.provider', 'github');

            $config->set('envbar.providers.github', [
                'token' => 'tallstackui',
                'repository' => 'tallstackui/envbar',
            ]);
        });

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Latest GitHub Release')
                ->assertSee('Latest GitHub Release')
                ->assertSee('v1.0.0');
        });
    }

    #[Test]
    public function page_survives_an_incomplete_configuration(): void
    {
        $this->beforeServingApplication(function ($app, Repository $config): void {
            $config->set('envbar.provider', 'github');

            $config->set('envbar.providers.github', [
                'token' => null,
                'repository' => null,
            ]);
        });

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Environment')
                ->assertSee('Environment')
                ->assertSee('testing')
                ->assertDontSee('Latest GitHub Release');
        });
    }
}
