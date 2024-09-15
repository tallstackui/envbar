<?php

namespace TallStackUi\EnvBar;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Vite;

class Renderer
{
    /** @throws Exception */
    public function style(): string
    {
        return app(Vite::class)('resources/css/app.css', 'build/.vite');
    }

    public function bar(): View
    {
        return view('envbar::components.envbar');
    }
}
