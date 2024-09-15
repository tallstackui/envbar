<?php

use Illuminate\Support\Collection;

if (! function_exists('__eb_configuration')) {
    function __eb_configuration(?string $index = null): Collection
    {
        $configuration = config('envbar');

        if ($index === null) {
            return collect($configuration);
        }

        if (! array_key_exists($index, $configuration)) {
            throw new Exception("Configuration key [{$index}] does not exist.");
        }

        return collect($configuration[$index]);
    }
}
