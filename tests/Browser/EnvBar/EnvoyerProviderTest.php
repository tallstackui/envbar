<?php

namespace Tests\Browser\EnvBar;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\Browser\BrowserTestCase;

class EnvoyerProviderTest extends BrowserTestCase
{
    #[Test]
    public function see_release(): void
    {
        $this->beforeServingApplication(function ($app, Repository $config): void {
            Cache::shouldReceive('has')->andReturnTrue();
            Cache::shouldReceive('get')->andReturn('v3.0.0');

            $config->set('envbar.provider', 'envoyer');

            $config->set('envbar.providers.envoyer', [
                'token' => 'tallstackui',
                'project_id' => '12345',
            ]);
        });

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Latest Envoyer Release')
                ->assertSee('Latest Envoyer Release')
                ->assertSee('v3.0.0');
        });
    }

    #[Test]
    #[TestWith(['', '12345'])]
    #[TestWith(['foo', ''])]
    public function throw_exception_when_parameters_is_empty(string $token, string $project): void
    {
        $this->beforeServingApplication(function ($app, Repository $config) use ($token, $project): void {
            Cache::shouldReceive('has')->andReturnTrue();
            Cache::shouldReceive('get')->andReturn('v3.0.0');

            $config->set('envbar.provider', 'envoyer');

            $config->set('envbar.providers.envoyer', [
                'token' => $token,
                'project_id' => $project,
            ]);
        });

        $this->browse(function (Browser $browser) use ($token): void {
            $expected = $token === '' ? 'token' : 'repository';

            $browser->visit('/')->assertSee("The Envoyer provider requires the $expected key to be set.");
        });
    }
}
