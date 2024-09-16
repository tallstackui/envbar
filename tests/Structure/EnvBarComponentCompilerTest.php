<?php

use TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler;

arch('should have all needed methods')
    ->expect(EnvBarComponentCompiler::class)
    ->toBeInvokable()
    ->toHaveMethods([
        '__invoke',
        'provider',
        'tailwind_breaking_points',
    ]);

arch('should only be used in Renderer class')
    ->expect(EnvBarComponentCompiler::class)
    ->toOnlyBeUsedIn('TallStackUi\EnvBar\Response\Render');
