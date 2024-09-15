<?php

namespace TallStackUi\EnvBar\Support\Compilers;

class BaseComponentCompiler
{
    public function __invoke(): array
    {
        $variables = ['configuration'];

        foreach ([
            'colors',
            'closable',
            'fixed',
        ] as $method) {
            $variables['configuration'][$method] = $this->{$method}();
        }

        return $variables;
    }

    private function colors(): string
    {
        $environments = config('envbar.environments');

        return match (data_get($environments, app()->environment(), 'primary')) {
            'green' => 'eb-border-l-green-500 eb-text-green-700 eb-bg-green-100',
            'yellow' => 'eb-border-l-yellow-500 eb-text-yellow-700 eb-bg-yellow-100',
            'blue' => 'eb-border-l-blue-500 eb-text-blue-700 eb-bg-blue-100',
            'red' => 'eb-border-l-red-500 eb-text-red-700 eb-bg-red-100',
            'slate' => 'eb-border-l-slate-500 eb-text-slate-700 eb-bg-slate-100',
            'gray' => 'eb-border-l-gray-500 eb-text-gray-700 eb-bg-gray-100',
            'zinc' => 'eb-border-l-zinc-500 eb-text-zinc-700 eb-bg-zinc-100',
            'neutral' => 'eb-border-l-neutral-500 eb-text-neutral-700 eb-bg-neutral-100',
            'stone' => 'eb-border-l-stone-500 eb-text-stone-700 eb-bg-stone-100',
            'orange' => 'eb-border-l-orange-500 eb-text-orange-700 eb-bg-orange-100',
            'amber' => 'eb-border-l-amber-500 eb-text-amber-700 eb-bg-amber-100',
            'lime' => 'eb-border-l-lime-500 eb-text-lime-700 eb-bg-lime-100',
            'emerald' => 'eb-border-l-emerald-500 eb-text-emerald-700 eb-bg-emerald-100',
            'teal' => 'eb-border-l-teal-500 eb-text-teal-700 eb-bg-teal-100',
            'cyan' => 'eb-border-l-cyan-500 eb-text-cyan-700 eb-bg-cyan-100',
            'sky' => 'eb-border-l-sky-500 eb-text-sky-700 eb-bg-sky-100',
            'indigo' => 'eb-border-l-indigo-500 eb-text-indigo-700 eb-bg-indigo-100',
            'violet' => 'eb-border-l-violet-500 eb-text-violet-700 eb-bg-violet-100',
            'purple' => 'eb-border-l-purple-500 eb-text-purple-700 eb-bg-purple-100',
            'fuchsia' => 'eb-border-l-fuchsia-500 eb-text-fuchsia-700 eb-bg-fuchsia-100',
            'pink' => 'eb-border-l-pink-500 eb-text-pink-700 eb-bg-pink-100',
            'rose' => 'eb-border-l-rose-500 eb-text-rose-700 eb-bg-rose-100',
            default => 'eb-border-l-eb-500 eb-text-green-700 eb-bg-eb-100',
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
