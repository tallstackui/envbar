<?php

use Illuminate\Support\Facades\Cache;
use TallStackUi\EnvBar\Console\FlushCommand;
use TallStackUi\EnvBar\Console\ShowCommand;

arch('should have all needed methods')
    ->expect([FlushCommand::class, ShowCommand::class])
    ->toHaveMethod('handle');

it('flushes the release and the failure cache of every provider', function () {
    foreach (array_keys(config('envbar.providers')) as $provider) {
        Cache::put('envbar::'.$provider.'::release', 'v1.0.0');
        Cache::put('envbar::'.$provider.'::release::failed', true);
    }

    $this->artisan('envbar:flush')->assertSuccessful();

    foreach (array_keys(config('envbar.providers')) as $provider) {
        expect(Cache::has('envbar::'.$provider.'::release'))->toBeFalse()
            ->and(Cache::has('envbar::'.$provider.'::release::failed'))->toBeFalse();
    }
});

it('flags the envbar to be shown again with an expiration', function () {
    $this->artisan('envbar:show')->assertSuccessful();

    expect(Cache::get('envbar::show'))->toBeTrue();
});
