<?php

namespace TallStackUi\EnvBar\Response;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;
use TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler;

class Render
{
    /**
     * Get the CSS content.
     */
    public static function css(): Htmlable
    {
        $css = file_get_contents(__DIR__.'/../../dist/app.css');

        return new HtmlString(<<<HTML
        <style data-source="envbar-css">{$css}</style>
        HTML);
    }

    /**
     * Get the JS content.
     */
    public static function js(): Htmlable
    {
        $js = file_get_contents(__DIR__.'/../../dist/app.js');

        return new HtmlString(<<<HTML
        <script data-source="envbar-js">{$js}</script>
        HTML);
    }

    /**
     * Get the EnvBar component.
     */
    public function component(): View
    {
        return view('envbar::components.envbar', [
            'id' => uniqid(),
            ...app(EnvBarComponentCompiler::class)(),
        ]);
    }

    /**
     * Handle the response injection.
     */
    public function handle(Response $response): Response
    {
        return (new ResponseHandle($this, $response))();
    }
}
