<?php

namespace TallStackUi\EnvBar\Support;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;

class Render
{
    public static function css(): Htmlable
    {
        $css = file_get_contents(__DIR__.'/../../dist/app.css');

        return new HtmlString(<<<HTML
        <style data-source="envbar">{$css}</style>
        HTML);
    }

    public function component(): View
    {
        return view('envbar::components.envbar');
    }
}
