<?php

namespace TallStackUi\EnvBar\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use TallStackUi\EnvBar\Support\PreventInjection;
use TallStackUi\EnvBar\Support\Render;

class Injection
{
    public function handle($request, Closure $next)
    {
        $abort = app(PreventInjection::class, ['request' => $request])->aborted();

        if ($abort) {
            return $next($request);
        }

        /** @var Response $response */
        $response = $next($request);

        $content = $response->getContent();

        $renderer = app(Render::class);

        $headPos = strripos($content, '</head>');
        if ($headPos !== false) {
            $content = substr($content, 0, $headPos).$renderer->style().substr($content, $headPos);
        }

        $bodyPos = strripos($content, '<body');
        if ($bodyPos !== false) {
            $bodyPos = strpos($content, '>', $bodyPos);
            $content = substr($content, 0, $bodyPos + 1).$renderer->component().substr($content, $bodyPos + 1);
        }

        $response->setContent($content);

        return $response;
    }
}
