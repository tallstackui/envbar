<?php

use TallStackUi\EnvBar\Providers\AbstractProvider;

arch('should have all needed methods')
    ->expect(AbstractProvider::class)
    ->toHaveConstructor()
    ->toHaveMethods([
        'fetch',
        'provider',
        'validate',
        'cacheKey',
    ]);
