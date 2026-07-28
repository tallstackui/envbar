<?php

use TallStackUi\EnvBar\Compilers\Colors;
use TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler;
use TallStackUi\EnvBar\View\Components\Badge;

arch('should have all needed methods')
    ->expect(Colors::class)
    ->toHaveMethods(['background', 'icons', 'badge']);

arch('should only be used in the compiler and the badge component')
    ->expect(Colors::class)
    ->toOnlyBeUsedIn([
        EnvBarComponentCompiler::class,
        Badge::class,
    ]);

it('resolves every block for the configured environment color', function () {
    config()->set('envbar.environments', [app()->environment() => 'red']);

    expect(Colors::background())->toBe('eb:border-l-red-500 eb:text-red-700 eb:bg-red-100')
        ->and(Colors::icons())->toBe('eb:h-6 eb:w-6 eb:text-red-700')
        ->and(Colors::badge())->toBe('eb:text-red-800 eb:bg-red-300');
});

it('falls back to the primary palette on an unknown color', function () {
    config()->set('envbar.environments', [app()->environment() => 'chartreuse']);

    expect(Colors::background())->toBe('eb:border-l-envbar-500 eb:text-envbar-700 eb:bg-envbar-100')
        ->and(Colors::icons())->toBe('eb:h-6 eb:w-6 eb:text-envbar-700')
        ->and(Colors::badge())->toBe('eb:text-envbar-800 eb:bg-envbar-300');
});

it('falls back to the primary palette when the environment is not mapped', function () {
    config()->set('envbar.environments', ['nonexistent' => 'green']);

    expect(Colors::badge())->toBe('eb:text-envbar-800 eb:bg-envbar-300');
});
