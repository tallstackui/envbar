<?php

use TallStackUi\EnvBar\Middleware\Injection;
use TallStackUi\EnvBar\Response\Render;
use TallStackUi\EnvBar\Response\ResponseHandle;

arch('should have all needed methods')
    ->expect(Render::class)
    ->toHaveMethods([
        'css',
        'js',
        'handle',
        'component',
    ]);

arch('should only be used in Injection and ResponseHandle class')
    ->expect(Render::class)
    ->toOnlyBeUsedIn([
        Injection::class,
        ResponseHandle::class,
    ]);
