<?php

namespace TallStackUi\EnvBar\Middleware;

use Closure;
use TallStackUi\EnvBar\Support\Response\PreventInjection;
use TallStackUi\EnvBar\Support\Response\Render;

class Injection
{
    public function handle($request, Closure $next)
    {
        if (app(PreventInjection::class, ['request' => $request])->aborted()) {
            return $next($request);
        }

        return app(Render::class)->handle($next($request));
    }
}
