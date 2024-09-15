<?php

namespace TallStackUi\EnvBar\Support\Response;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Fluent;

readonly class PreventInjection
{
    public function __construct(private Request $request)
    {
        //
    }

    /**
     * Determine if the injection should be aborted.
     */
    public function aborted(): bool
    {
        if (! config('envbar.enabled')) {
            return true;
        }

        if ($this->forRoutes()) {
            return true;
        }

        if ($this->forAuthenticatedUsers()) {
            return true;
        }

        if ($this->forEnvironments()) {
            return true;
        }

        if ($this->forMobile()) {
            return true;
        }

        return false;
    }

    private function forRoutes(): bool
    {
        return collect(config('envbar.ignore_on'))
            ->contains(fn (string $route) => $this->request->is($route));
    }

    private function forAuthenticatedUsers(): bool
    {
        $fluent = new Fluent(config('envbar.for_authenticated_users'));

        if (! $fluent->get('enabled')) {
            return false;
        }

        return ! Gate::allows('envbar::view', $this->request->user($fluent->get('guard')));
    }

    private function forEnvironments(): bool
    {
        return ! in_array(app()->environment(), array_keys(config('envbar.environments')));
    }

    private function forMobile(): bool
    {
        if (config('envbar.on_mobile')) {
            return false;
        }

        return rescue(fn () => (new MobileDetect)->isMobile(), false);
    }
}
