<?php

namespace Tests\Browser\EnvBar;

use Illuminate\Config\Repository;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\Browser\BrowserTestCase;

class IndexTest extends BrowserTestCase
{
    #[Test]
    public function is_visible(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Environment')
                ->assertSee('Environment')
                ->assertSee('testing');
        });
    }

    #[Test]
    public function warning_visible(): void
    {
        $fake = fake()->sentence(10);

        $this->beforeServingApplication(fn ($app, Repository $config) => $config->set('envbar.warning_message', $fake));

        $this->browse(function (Browser $browser) use ($fake): void {
            $browser->visit('/')
                ->waitForText('Environment')
                ->assertSee('Environment')
                ->assertSee('testing')
                ->assertSee($fake);
        });
    }

    #[Test]
    public function ignore_successfully(): void
    {
        $this->beforeServingApplication(fn ($app, Repository $config) => $config->set('envbar.ignore_on', ['/']));

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitUntilMissingText('Environment')
                ->assertDontSee('Environment')
                ->assertDontSee('testing');
        });
    }

    #[Test]
    public function closable_visible(): void
    {
        $this->beforeServingApplication(fn ($app, Repository $config) => $config->set('envbar.closable.enabled', true));

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')->assertPresent('@envbar_close_button');
        });
    }

    #[Test]
    public function closable_works_successfully(): void
    {
        $this->beforeServingApplication(fn ($app, Repository $config) => $config->set('envbar.closable.enabled', true));

        $this->browse(function (Browser $browser): void {
            $browser->visit('/')
                ->waitForText('Environment')
                ->assertSee('Environment')
                ->assertSee('testing')
                ->click('@envbar_close_button')
                ->waitUntilMissingText('Environment')
                ->assertDontSee('Environment')
                ->assertDontSee('testing');
        });
    }
}
