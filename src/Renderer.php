<?php

namespace TallStackUi\EnvBar;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Vite;

class Renderer
{
    /** @throws Exception */
    public function style(): string
    {
        return Vite::useBuildDirectory('vendor/tallstackui/envbar')
            ->withEntryPoints([
                'resources/css/app.css',
                'resources/js/app.js',
            ])
            ->toHtml();
    }

    public function bar(): View
    {
        $prefix = config('tallstackui.prefix');

        return view('envbar::components.envbar');
    }
}
