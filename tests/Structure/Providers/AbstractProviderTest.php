<?php

use TallStackUi\EnvBar\Providers\AbstractProvider;

arch('should have all needed methods')
    ->expect(AbstractProvider::class)
    ->toHaveMethods([
        'fetch',
        'provider',
        'validate',
        'cacheKey',
        'failureCacheKey',
        'configuration',
        'release',
    ]);
