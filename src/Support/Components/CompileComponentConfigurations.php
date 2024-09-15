<?php

namespace TallStackUi\EnvBar\Support\Components;

class CompileComponentConfigurations
{
    public function __invoke(): array
    {
        $variables = [];

        foreach ([
            'backgroundColor',
        ] as $method) {
            $variables[$method] = $this->{$method}();
        }

        return $variables;
    }

    private function backgroundColor(): string
    {
        $environments = config('envbar.environments');

        return match (data_get($environments, app()->environment(), 'primary')) {
            'green' => 'eb-bg-green-500',
            'yellow' => 'eb-bg-yellow-500',
            'blue' => 'eb-bg-blue-500',
            'red' => 'eb-bg-red-500',
            default => 'eb-bg-eb-500',
        };
    }
}
