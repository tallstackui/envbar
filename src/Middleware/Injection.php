<?php

namespace TallStackUi\EnvBar\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use TallStackUi\EnvBar\Response\PreventInjection;
use TallStackUi\EnvBar\Response\Render;

class Injection
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (app(PreventInjection::class, ['request' => $request])->aborted()) {
            return $response;
        }

        if (! $response->isSuccessful()) {
            return $response;
        }

        return app(Render::class)->handle($response);
    }
}
