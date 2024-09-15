<?php

namespace TallStackUi\EnvBar\Support;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Vite;

class Render
{
    public static function style(): string
    {
        return Vite::useBuildDirectory('vendor/tallstackui/envbar')
            ->withEntryPoints([
                'resources/css/app.css',
                'resources/js/app.js',
            ])
            ->toHtml();
    }

    public function component(): View
    {
        return view('envbar::components.envbar');
    }
}
