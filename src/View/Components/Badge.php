<?php

namespace TallStackUi\EnvBar\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentSlot;
use TallStackUi\EnvBar\Compilers\Colors;

class Badge extends BaseComponent
{
    public function __construct(
        public ?string $text = null,
        public ?string $size = null,
        public ComponentSlot|string|null $icon = null,
    ) {
        $this->size = match ($this->size) {
            'xs' => 'xs',
            'sm' => 'sm',
            'lg' => 'lg',
            'xl' => 'xl',
            default => 'md',
        };
    }

    public function blade(): View
    {
        return view('envbar::components.badge', ['color' => Colors::badge()]);
    }
}
