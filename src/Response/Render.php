<?php

namespace TallStackUi\EnvBar\Response;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use TallStackUi\EnvBar\Compilers\EnvBarComponentCompiler;

class Render
{
    /** @var array<string, string> */
    private static array $assets = [];

    /**
     * Get the CSS content.
     */
    public function css(): Htmlable
    {
        $css = $this->asset('app.css');

        return new HtmlString(<<<HTML
        <style data-source="envbar-css"{$this->nonce()}>{$css}</style>
        HTML);
    }

    /**
     * Get the JS content.
     */
    public function js(): Htmlable
    {
        $js = $this->asset('app.js');

        return new HtmlString(<<<HTML
        <script data-source="envbar-js"{$this->nonce()}>{$js}</script>
        HTML);
    }

    /**
     * Get the EnvBar component.
     */
    public function component(): View
    {
        return view('envbar::components.envbar', [
            'show' => Cache::pull('envbar::show'),
            'nonce' => $this->nonce(),
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

    /**
     * Read a built asset, memoized for the whole request.
     */
    private function asset(string $file): string
    {
        return self::$assets[$file] ??= $this->read($file);
    }

    /**
     * Read a built asset from disk, degrading to an empty string when it is missing.
     */
    private function read(string $file): string
    {
        $path = __DIR__.'/../../public/build/'.$file;

        if (! is_file($path)) {
            report(new RuntimeException("The EnvBar asset [{$file}] was not found. Run [npm run build] on the package root."));

            return '';
        }

        return (string) file_get_contents($path);
    }

    /**
     * Resolve the CSP nonce attribute. The configuration accepts the nonce
     * itself or `true` to reuse the one already registered on Vite.
     */
    private function nonce(): string
    {
        $nonce = config('envbar.nonce');

        if ($nonce === true) {
            $nonce = rescue(fn () => app(Vite::class)->cspNonce(), null, false);
        }

        if (! is_string($nonce) || blank($nonce)) {
            return '';
        }

        return ' nonce="'.e($nonce).'"';
    }
}
