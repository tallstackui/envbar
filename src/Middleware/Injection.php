<?php

namespace TallStackUi\EnvBar\Middleware;

use Closure;
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

        return app(Render::class)->handle($next($request));
    }
}
