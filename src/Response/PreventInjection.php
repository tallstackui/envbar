<?php

namespace TallStackUi\EnvBar\Response;

use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Fluent;

class PreventInjection
{
    public function __construct(private readonly Request $request)
    {
        //
    }

    /**
     * Determine if the injection should be aborted.
     */
    public function aborted(): bool
    {
        if (! config('envbar.enabled') || (config('envbar.disable_on_tests') === true && app()->runningUnitTests())) {
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

    /**
     * Abort the injection according to the route rule.
     */
    private function forRoutes(): bool
    {
        return collect(config('envbar.ignore_on'))
            ->contains(fn (string $route) => $this->request->is($route));
    }

    /**
     * Abort the injection according to the authenticated user rule.
     */
    private function forAuthenticatedUsers(): bool
    {
        $fluent = new Fluent(config('envbar.for_authenticated_users'));

        if (! $fluent->get('enabled')) {
            return false;
        }

        return ! Gate::allows('envbar::view', $this->request->user($fluent->get('guard')));
    }

    /**
     * Abort the injection according to the environment rule.
     */
    private function forEnvironments(): bool
    {
        if (($environments = config('envbar.environments')) === '*') {
            return false;
        }

        return ! in_array(app()->environment(), array_keys($environments ?? []));
    }

    /**
     * Abort the injection according to the mobile rule.
     */
    private function forMobile(): bool
    {
        if (config('envbar.on_mobile')) {
            return false;
        }

        return rescue(fn () => (new MobileDetect)->isMobile(), false, false);
    }
}
