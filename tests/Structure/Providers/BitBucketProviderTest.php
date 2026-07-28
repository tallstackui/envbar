<?php

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use TallStackUi\EnvBar\Providers\AbstractProvider;
use TallStackUi\EnvBar\Providers\BitBucketProvider;

arch('should have all needed methods')
    ->expect(BitBucketProvider::class)
    ->toHaveMethods(['fetch', 'provider']);

arch('should extend AbstractProvider')
    ->expect(BitBucketProvider::class)
    ->toExtend(AbstractProvider::class);

arch('should have keys property', function () {
    $reflection = new ReflectionClass(BitBucketProvider::class);

    expect($reflection->getProperty('keys'))->not
        ->toBeNull()
        ->and($reflection->getProperty('keys')->isProtected())
        ->toBeTrue();
});

beforeEach(function () {
    config()->set('envbar.provider', 'bitbucket');
    config()->set('envbar.providers.bitbucket', [
        'token' => 'secret',
        'repository' => 'tallstackui/envbar',
        'cached_for' => 1,
    ]);
});

it('fetches and caches the latest tag', function () {
    Http::fake(['api.bitbucket.org/*' => Http::response(['values' => [['name' => 'v2.0.0']]])]);

    expect(app(BitBucketProvider::class)->fetch())->toBe('v2.0.0');
    expect(Cache::get('envbar::bitbucket::release'))->toBe('v2.0.0');

    Http::assertSentCount(1);
});

it('serves the cached tag without hitting the api', function () {
    Http::fake();

    Cache::put('envbar::bitbucket::release', 'v9.9.9');

    expect(app(BitBucketProvider::class)->fetch())->toBe('v9.9.9');

    Http::assertNothingSent();
});

it('remembers a failure and stops requesting the api', function () {
    Http::fake(['api.bitbucket.org/*' => Http::response(status: 403)]);

    expect(fn () => app(BitBucketProvider::class)->fetch())->toThrow(RequestException::class);
    expect(Cache::has('envbar::bitbucket::release::failed'))->toBeTrue();

    expect(app(BitBucketProvider::class)->fetch())->toBeNull();

    Http::assertSentCount(1);
});

it('throws when a required key is missing', function (string $token, string $repository, string $expected) {
    config()->set('envbar.providers.bitbucket', ['token' => $token, 'repository' => $repository]);

    expect(fn () => app(BitBucketProvider::class)->fetch())
        ->toThrow(Exception::class, "The BitBucket provider requires the {$expected} key to be set.");
})->with([
    ['', 'foo/bar', 'token'],
    ['foo', '', 'repository'],
]);

it('throws when another provider is configured', function () {
    config()->set('envbar.provider', 'github');

    expect(fn () => app(BitBucketProvider::class)->fetch())
        ->toThrow(Exception::class, 'The provider was not set to: bitbucket.');
});
