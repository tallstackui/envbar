<?php

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use TallStackUi\EnvBar\Providers\AbstractProvider;
use TallStackUi\EnvBar\Providers\GitHubProvider;

arch('should have all needed methods')
    ->expect(GitHubProvider::class)
    ->toHaveMethods(['fetch', 'provider']);

arch('should extend AbstractProvider')
    ->expect(GitHubProvider::class)
    ->toExtend(AbstractProvider::class);

arch('should have keys property', function () {
    $reflection = new ReflectionClass(GitHubProvider::class);

    expect($reflection->getProperty('keys'))->not
        ->toBeNull()
        ->and($reflection->getProperty('keys')->isProtected())
        ->toBeTrue();
});

beforeEach(function () {
    config()->set('envbar.provider', 'github');
    config()->set('envbar.providers.github', [
        'token' => 'secret',
        'repository' => 'tallstackui/envbar',
        'cached_for' => 1,
    ]);
});

it('fetches and caches the latest tag', function () {
    Http::fake(['api.github.com/*' => Http::response([['name' => 'v1.2.3']])]);

    expect(app(GitHubProvider::class)->fetch())->toBe('v1.2.3');
    expect(Cache::get('envbar::github::release'))->toBe('v1.2.3');

    Http::assertSentCount(1);
});

it('serves the cached tag without hitting the api', function () {
    Http::fake();

    Cache::put('envbar::github::release', 'v9.9.9');

    expect(app(GitHubProvider::class)->fetch())->toBe('v9.9.9');

    Http::assertNothingSent();
});

it('remembers a failure and stops requesting the api', function () {
    Http::fake(['api.github.com/*' => Http::response(status: 401)]);

    expect(fn () => app(GitHubProvider::class)->fetch())->toThrow(RequestException::class);
    expect(Cache::has('envbar::github::release::failed'))->toBeTrue();

    expect(app(GitHubProvider::class)->fetch())->toBeNull();

    Http::assertSentCount(1);
});

it('throws when a required key is missing', function (string $token, string $repository, string $expected) {
    config()->set('envbar.providers.github', ['token' => $token, 'repository' => $repository]);

    expect(fn () => app(GitHubProvider::class)->fetch())
        ->toThrow(Exception::class, "The GitHub provider requires the {$expected} key to be set.");
})->with([
    ['', 'foo/bar', 'token'],
    ['foo', '', 'repository'],
]);

it('throws when another provider is configured', function () {
    config()->set('envbar.provider', 'bitbucket');

    expect(fn () => app(GitHubProvider::class)->fetch())
        ->toThrow(Exception::class, 'The provider was not set to: github.');
});
