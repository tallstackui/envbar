<?php

namespace TallStackUi\EnvBar\Support\Components;

class CompileComponentConfigurations
{
    public function __invoke(): array
    {
        $variables = [];

        foreach ([
            'backgroundColor',
            'closable',
            'fixed',
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
            'slate' => 'eb-bg-slate-500',
            'gray' => 'eb-bg-gray-500',
            'zinc' => 'eb-bg-zinc-500',
            'neutral' => 'eb-bg-neutral-500',
            'stone' => 'eb-bg-stone-500',
            'orange' => 'eb-bg-orange-500',
            'amber' => 'eb-bg-amber-500',
            'lime' => 'eb-bg-lime-500',
            'emerald' => 'eb-bg-emerald-500',
            'teal' => 'eb-bg-teal-500',
            'cyan' => 'eb-bg-cyan-500',
            'sky' => 'eb-bg-sky-500',
            'indigo' => 'eb-bg-indigo-500',
            'violet' => 'eb-bg-violet-500',
            'purple' => 'eb-bg-purple-500',
            'fuchsia' => 'eb-bg-fuchsia-500',
            'pink' => 'eb-bg-pink-500',
            'rose' => 'eb-bg-rose-500',
            'black' => 'eb-bg-black',
            default => 'eb-bg-eb-500',
        };
    }

    private function closable(): array
    {
        return config('envbar.closable');
    }

    private function fixed(): bool
    {
        return config('envbar.fixed');
    }
}
