<?php

use TallStackUi\EnvBar\View\Components\Badge;
use TallStackUi\EnvBar\View\Components\BaseComponent;

arch('should have all needed methods')
    ->expect(Badge::class)
    ->toHaveConstructor()
    ->toHaveMethods([
        'blade',
        'colors',
    ]);

arch('should extend BaseComponent')
    ->expect(Badge::class)
    ->toExtend(BaseComponent::class);
