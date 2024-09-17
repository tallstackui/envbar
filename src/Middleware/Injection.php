<?php

namespace TallStackUi\EnvBar\Middleware;

use Closure;
use TallStackUi\EnvBar\Response\PreventInjection;
use TallStackUi\EnvBar\Response\Render;

class Injection
{
    public function handle($request, Closure $next) // @pest-ignore-type
    {
        if (app(PreventInjection::class, ['request' => $request])->aborted()) {
            return $next($request);
        }

        $response = $next($request);

        return app(Render::class)->handle($response);
    }
}
