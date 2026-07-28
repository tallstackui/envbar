<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler;

arch('should have all needed methods')
    ->expect(EnvBarComponentCompiler::class)
    ->toBeInvokable()
    ->toHaveMethods([
        '__invoke',
        'label',
        'release',
        'links',
        'tailwind_breaking_points',
    ]);

arch('should only be used in Renderer class')
    ->expect(EnvBarComponentCompiler::class)
    ->toOnlyBeUsedIn('TallStackUi\EnvBar\Response\Render');

it('parses links with and without labels', function () {
    config()->set('envbar.links', ['Google|https://google.com', 'https://github.com', '']);

    expect(app(EnvBarComponentCompiler::class)()['configuration']['links'])->toBe([
        ['name' => 'Google', 'url' => 'https://google.com'],
        ['name' => 'https://github.com', 'url' => 'https://github.com'],
    ]);
});

it('returns null when there are no links', function () {
    config()->set('envbar.links', ['']);

    expect(app(EnvBarComponentCompiler::class)()['configuration']['links'])->toBeNull();
});

it('resolves the provider label from the translations', function () {
    config()->set('envbar.provider', 'github');
    config()->set('envbar.providers.github', [
        'token' => 'secret',
        'repository' => 'tallstackui/envbar',
        'cached_for' => 1,
    ]);

    Cache::put('envbar::github::release', 'v1.0.0');

    $environment = app(EnvBarComponentCompiler::class)()['environment'];

    expect($environment['provider'])->toBe('GitHub')
        ->and($environment['release'])->toBe('v1.0.0');
});

it('falls back to the raw provider value when there is no translation', function () {
    config()->set('envbar.provider', 'gitlab');

    expect(app(EnvBarComponentCompiler::class)()['environment']['provider'])->toBe('gitlab');
});

it('has no provider label when none is configured', function () {
    config()->set('envbar.provider', null);

    expect(app(EnvBarComponentCompiler::class)()['environment']['provider'])->toBeNull();
});

it('degrades the release to null when the provider fails', function () {
    config()->set('envbar.provider', 'github');
    config()->set('envbar.providers.github', ['token' => null, 'repository' => null]);

    expect(app(EnvBarComponentCompiler::class)()['environment']['release'])->toBeNull();
});

it('disables the breakpoints without a tailwind config file', function () {
    config()->set('envbar.tailwind_breaking_points', true);

    expect(app(EnvBarComponentCompiler::class)()['configuration']['tailwind_breaking_points'])->toBeFalse();
});

it('enables the breakpoints with a tailwind config file', function () {
    config()->set('envbar.tailwind_breaking_points', true);

    File::put($path = base_path('tailwind.config.js'), '');

    try {
        expect(app(EnvBarComponentCompiler::class)()['configuration']['tailwind_breaking_points'])->toBeTrue();
    } finally {
        File::delete($path);
    }
});
