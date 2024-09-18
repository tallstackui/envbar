<?php

namespace TallStackUi\EnvBar\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    abstract public function blade(): View;

    public function render(): Closure
    {
        return fn (): View => $this->blade();
    }
}
