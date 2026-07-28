<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use TallStackUi\EnvBar\Response\PreventInjection;

arch('should have all needed methods')
    ->expect(PreventInjection::class)
    ->toHaveConstructor()
    ->toHaveMethods([
        'aborted',
        'forMobile',
        'forRoutes',
        'forEnvironments',
        'forAuthenticatedUsers',
    ]);

function envbarAborted(?Request $request = null): bool
{
    return (new PreventInjection($request ?? Request::create('/')))->aborted();
}

function envbarWithUserAgent(string $agent, callable $callback): void
{
    $original = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $_SERVER['HTTP_USER_AGENT'] = $agent;

    try {
        $callback();
    } finally {
        if ($original === null) {
            unset($_SERVER['HTTP_USER_AGENT']);
        } else {
            $_SERVER['HTTP_USER_AGENT'] = $original;
        }
    }
}

beforeEach(function () {
    config()->set('envbar.enabled', true);
    config()->set('envbar.disable_on_tests', false);
    config()->set('envbar.environments', '*');
    config()->set('envbar.ignore_on', []);
    config()->set('envbar.on_mobile', true);
    config()->set('envbar.for_authenticated_users.enabled', false);
});

it('does not abort when everything is allowed', function () {
    expect(envbarAborted())->toBeFalse();
});

it('aborts when disabled', function () {
    config()->set('envbar.enabled', false);

    expect(envbarAborted())->toBeTrue();
});

it('aborts on tests when configured to', function () {
    config()->set('envbar.disable_on_tests', true);

    expect(envbarAborted())->toBeTrue();
});

it('does not abort when the environment is listed', function () {
    config()->set('envbar.environments', [app()->environment() => 'green']);

    expect(envbarAborted())->toBeFalse();
});

it('aborts when the environment is not listed', function () {
    config()->set('envbar.environments', ['nonexistent' => 'green']);

    expect(envbarAborted())->toBeTrue();
});

it('aborts when the environments configuration is malformed', function () {
    config()->set('envbar.environments', 'everything');

    expect(envbarAborted())->toBeTrue();
});

it('aborts on ignored routes', function () {
    config()->set('envbar.ignore_on', ['ignored.*']);

    Route::get('/ignored', fn () => 'ok')->name('ignored.page');

    $request = Request::create('/ignored');
    $request->setRouteResolver(fn () => Route::getRoutes()->match($request));

    expect(envbarAborted($request))->toBeTrue();
});

it('does not abort on routes that are not ignored', function () {
    config()->set('envbar.ignore_on', ['ignored.*']);

    Route::get('/allowed', fn () => 'ok')->name('allowed.page');

    $request = Request::create('/allowed');
    $request->setRouteResolver(fn () => Route::getRoutes()->match($request));

    expect(envbarAborted($request))->toBeFalse();
});

it('aborts when the gate denies the user', function () {
    config()->set('envbar.for_authenticated_users.enabled', true);

    Gate::define('envbar::view', fn (?Authenticatable $user) => false);

    expect(envbarAborted())->toBeTrue();
});

it('does not abort when the gate allows the user', function () {
    config()->set('envbar.for_authenticated_users.enabled', true);

    Gate::define('envbar::view', fn (?Authenticatable $user) => true);

    expect(envbarAborted())->toBeFalse();
});

it('aborts on mobile devices when they are not allowed', function () {
    config()->set('envbar.on_mobile', false);

    envbarWithUserAgent(
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        fn () => expect(envbarAborted())->toBeTrue()
    );
});

it('does not abort on mobile devices when they are allowed', function () {
    config()->set('envbar.on_mobile', true);

    envbarWithUserAgent(
        'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148',
        fn () => expect(envbarAborted())->toBeFalse()
    );
});
