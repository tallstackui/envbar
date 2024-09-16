<?php

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
