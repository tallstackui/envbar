<?php

namespace TallStackUi\EnvBar\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PreventInjection
{
    public function __construct(
        private readonly Request $request,
        private ?Collection $configuration = null,
    ) {
        $this->configuration = collect(config('envbar'));
    }

    public function aborted(): bool
    {
        // status
        if (! $this->configuration->get('enabled')) {
            return true;
        }

        // Gate

        // enviroments
        if (! in_array(app()->environment(), $this->configuration->get('environments'))) {
            return true;
        }

        // check if the request is mobile

        // check if the request is part of a specific browser

        return false;
    }
}
