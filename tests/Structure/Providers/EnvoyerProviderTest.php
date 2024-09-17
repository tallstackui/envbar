<?php

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
