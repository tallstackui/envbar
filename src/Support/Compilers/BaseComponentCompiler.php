<?php

namespace TallStackUi\EnvBar\Support\Compilers;

class BaseComponentCompiler
{
    public function __invoke(): array
    {
        $variables = ['configuration'];

        foreach ([
            'background',
            'closable',
            'fixed',
        ] as $method) {
            $variables['configuration'][$method] = $this->{$method}();
        }

        return $variables;
    }

    private function background(): string
    {
        $environments = config('envbar.environments');

        return match (data_get($environments, app()->environment(), 'primary')) {
            'green' => 'eb-border-l-green-500 eb-bg-green-200',
            'yellow' => 'eb-border-l-yellow-500 eb-bg-yellow-200',
            'blue' => 'eb-border-l-blue-500 eb-bg-blue-200',
            'red' => 'eb-border-l-red-500 eb-bg-red-200',
            'slate' => 'eb-border-l-slate-500 eb-bg-slate-200',
            'gray' => 'eb-border-l-gray-500 eb-bg-gray-200',
            'zinc' => 'eb-border-l-zinc-500 eb-bg-zinc-200',
            'neutral' => 'eb-border-l-neutral-500 eb-bg-neutral-200',
            'stone' => 'eb-border-l-stone-500 eb-bg-stone-200',
            'orange' => 'eb-border-l-orange-500 eb-bg-orange-200',
            'amber' => 'eb-border-l-amber-500 eb-bg-amber-200',
            'lime' => 'eb-border-l-lime-500 eb-bg-lime-200',
            'emerald' => 'eb-border-l-emerald-500 eb-bg-emerald-200',
            'teal' => 'eb-border-l-teal-500 eb-bg-teal-200',
            'cyan' => 'eb-border-l-cyan-500 eb-bg-cyan-200',
            'sky' => 'eb-border-l-sky-500 eb-bg-sky-200',
            'indigo' => 'eb-border-l-indigo-500 eb-bg-indigo-200',
            'violet' => 'eb-border-l-violet-500 eb-bg-violet-200',
            'purple' => 'eb-border-l-purple-500 eb-bg-purple-200',
            'fuchsia' => 'eb-border-l-fuchsia-500 eb-bg-fuchsia-200',
            'pink' => 'eb-border-l-pink-500 eb-bg-pink-200',
            'rose' => 'eb-border-l-rose-500 eb-bg-rose-200',
            'black' => 'eb-border-l-black eb-bg-black',
            default => 'eb-border-l-eb-500 eb-bg-eb-200',
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
