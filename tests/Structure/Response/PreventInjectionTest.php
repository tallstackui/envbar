<?php

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

arch('should be readonly')
    ->expect(PreventInjection::class)
    ->toBeReadonly();
