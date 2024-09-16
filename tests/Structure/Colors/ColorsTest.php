<?php

use TallStackUi\EnvBar\Compilers\Colors\Colors;

arch('should have all needed methods')
    ->expect(Colors::class)
    ->toHaveMethods(['background', 'icons']);

arch('should only be used in EnvBarComponentCompiler class')
    ->expect(Colors::class)
    ->toOnlyBeUsedIn('TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler');
