<?php

namespace Tests\Browser\EnvBar;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\Browser\BrowserTestCase;

class EnvoyerProviderTest extends BrowserTestCase
{
    #[Test]
    public function see_release(): void
    {
        $this->beforeServingApplication(function ($app, Repository $config): void {
            Cache::shouldReceive('has')->andReturnTrue();
            Cache::shouldReceive('get')->andReturn('v3.0.0');
            Cache::shouldReceive('pull')->andReturnNull();

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
    public function page_survives_an_incomplete_configuration(): void
    {
        $this->beforeServingApplication(function ($app, Repository $config): void {
            $config->set('envbar.provider', 'envoyer');

            $config->set('envbar.providers.envoyer', [
                'token' => null,
                'project_id' => null,
            ]);
        });

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Environment')
                ->assertSee('Environment')
                ->assertSee('testing')
                ->assertDontSee('Latest Envoyer Release');
        });
    }
}
