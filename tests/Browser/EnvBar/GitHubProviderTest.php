<?php

namespace Tests\Browser\EnvBar;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
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
                'repository' => 'tallstack/tallstack-ui',
            ]);
        });

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Latest Github Release')
                ->assertSee('Latest Github Release')
                ->assertSee('v1.0.0');
        });
    }

    #[Test]
    #[TestWith(['', 'foo/bar'])]
    #[TestWith(['foo', ''])]
    public function throw_exception_when_parameters_is_empty(string $token, string $repository): void
    {
        $this->beforeServingApplication(function ($app, Repository $config) use ($token, $repository): void {
            Cache::shouldReceive('has')->andReturnTrue();
            Cache::shouldReceive('get')->andReturn('v1.0.0');
            Cache::shouldReceive('pull')->andReturnNull();

            $config->set('envbar.provider', 'github');

            $config->set('envbar.providers.github', [
                'token' => $token,
                'repository' => $repository,
            ]);
        });

        $this->browse(function (Browser $browser) use ($token): void {
            $expected = $token === '' ? 'token' : 'repository';

            $browser->visit('/')->assertSee("The GitHub provider requires the $expected key to be set.");
        });
    }
}
