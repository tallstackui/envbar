<?php

namespace TallStackUi\EnvBar\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    /** Runtime configurations obtained from the EnvBar component. */
    public array $configuration = [];

    abstract public function blade(): View;

    public function render(): Closure
    {
        return function (): View {
            return $this->blade()->with([
                'configuration' => $this->configuration = $this->attributes->get('configuration', []),
            ]);
        };
    }
}
