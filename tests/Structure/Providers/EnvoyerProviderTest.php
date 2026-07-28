<?php

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use TallStackUi\EnvBar\Providers\AbstractProvider;
use TallStackUi\EnvBar\Providers\EnvoyerProvider;

arch('should have all needed methods')
    ->expect(EnvoyerProvider::class)
    ->toHaveMethods(['fetch', 'provider']);

arch('should extend AbstractProvider')
    ->expect(EnvoyerProvider::class)
    ->toExtend(AbstractProvider::class);

arch('should have keys property', function () {
    $reflection = new ReflectionClass(EnvoyerProvider::class);

    expect($reflection->getProperty('keys'))->not
        ->toBeNull()
        ->and($reflection->getProperty('keys')->isProtected())
        ->toBeTrue();
});

beforeEach(function () {
    config()->set('envbar.provider', 'envoyer');
    config()->set('envbar.providers.envoyer', [
        'token' => 'secret',
        'project_id' => '12345',
        'cached_for' => 1,
    ]);
});

it('fetches and caches the last deployed branch', function () {
    Http::fake(['envoyer.io/*' => Http::response(['project' => ['last_deployed_branch' => 'v3.0.0']])]);

    expect(app(EnvoyerProvider::class)->fetch())->toBe('v3.0.0');
    expect(Cache::get('envbar::envoyer::release'))->toBe('v3.0.0');

    Http::assertSentCount(1);
});

it('serves the cached branch without hitting the api', function () {
    Http::fake();

    Cache::put('envbar::envoyer::release', 'v9.9.9');

    expect(app(EnvoyerProvider::class)->fetch())->toBe('v9.9.9');

    Http::assertNothingSent();
});

it('remembers a failure and stops requesting the api', function () {
    Http::fake(['envoyer.io/*' => Http::response(status: 500)]);

    expect(fn () => app(EnvoyerProvider::class)->fetch())->toThrow(RequestException::class);
    expect(Cache::has('envbar::envoyer::release::failed'))->toBeTrue();

    expect(app(EnvoyerProvider::class)->fetch())->toBeNull();

    Http::assertSentCount(1);
});

it('throws when a required key is missing', function (string $token, string $project, string $expected) {
    config()->set('envbar.providers.envoyer', ['token' => $token, 'project_id' => $project]);

    expect(fn () => app(EnvoyerProvider::class)->fetch())
        ->toThrow(Exception::class, "The Envoyer provider requires the {$expected} key to be set.");
})->with([
    ['', '12345', 'token'],
    ['foo', '', 'project_id'],
]);

it('throws when another provider is configured', function () {
    config()->set('envbar.provider', 'github');

    expect(fn () => app(EnvoyerProvider::class)->fetch())
        ->toThrow(Exception::class, 'The provider was not set to: envoyer.');
});
