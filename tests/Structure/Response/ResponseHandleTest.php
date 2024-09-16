<?php

use TallStackUi\EnvBar\Response\Render;
use TallStackUi\EnvBar\Response\ResponseHandle;

arch('should have all needed methods')
    ->expect(ResponseHandle::class)
    ->toHaveConstructor()
    ->toBeInvokable();

arch('should only be used in Render class')
    ->expect(ResponseHandle::class)
    ->toOnlyBeUsedIn(Render::class);
