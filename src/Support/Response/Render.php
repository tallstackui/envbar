<?php

namespace TallStackUi\EnvBar\Support\Response;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;
use TallStackUi\EnvBar\Support\Components\CompileComponentConfigurations;

class Render
{
    public static function css(): Htmlable
    {
        $css = file_get_contents(__DIR__.'/../../../dist/app.css');

        return new HtmlString(<<<HTML
        <style data-source="envbar-css">{$css}</style>
        HTML);
    }

    public static function js(): Htmlable
    {
        $js = file_get_contents(__DIR__.'/../../../dist/app.js');

        return new HtmlString(<<<HTML
        <script data-source="envbar-js">{$js}</script>
        HTML);
    }

    public function component(): View
    {
        return view('envbar::components.envbar', [...app(CompileComponentConfigurations::class)()]);
    }

    public function handle(Response $response): Response
    {
        return (new ResponseHandle($this, $response))();
    }
}
