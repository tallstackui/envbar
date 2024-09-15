<?php

namespace TallStackUi\EnvBar\View\Components;

use Illuminate\Contracts\View\View;

class Badge extends BaseComponent
{
    public function __construct(
        public ?string $text = null,
    ) {
        //
    }

    public function blade(): View
    {
        return view('envbar::components.badge');
    }

    public function colors(): string
    {
        return match (data_get(config('envbar.environments'), app()->environment(), 'primary')) {
            'green' => 'eb-text-green-600 eb-ring-green-500/30 eb-bg-green-50',
            'yellow' => 'eb-text-yellow-600 eb-ring-yellow-500/30 eb-bg-yellow-50',
            'blue' => 'eb-text-blue-600 eb-ring-blue-500/30 eb-bg-blue-50',
            'red' => 'eb-text-red-600 eb-ring-red-500/30 eb-bg-red-50',
            'slate' => 'eb-text-slate-600 eb-ring-slate-500/30 eb-bg-slate-50',
            'gray' => 'eb-text-gray-600 eb-ring-gray-500/30 eb-bg-gray-50',
            'zinc' => 'eb-text-zinc-600 eb-ring-zinc-500/30 eb-bg-zinc-50',
            'neutral' => 'eb-text-neutral-600 eb-ring-neutral-500/30 eb-bg-neutral-50',
            'stone' => 'eb-text-stone-600 eb-ring-stone-500/30 eb-bg-stone-50',
            'orange' => 'eb-text-orange-600 eb-ring-orange-500/30 eb-bg-orange-50',
            'amber' => 'eb-text-amber-600 eb-ring-amber-500/30 eb-bg-amber-50',
            'lime' => 'eb-text-lime-600 eb-ring-lime-500/30 eb-bg-lime-50',
            'emerald' => 'eb-text-emerald-600 eb-ring-emerald-500/30 eb-bg-emerald-50',
            'teal' => 'eb-text-teal-600 eb-ring-teal-500/30 eb-bg-teal-50',
            'cyan' => 'eb-text-cyan-600 eb-ring-cyan-500/30 eb-bg-cyan-50',
            'sky' => 'eb-text-sky-600 eb-ring-sky-500/30 eb-bg-sky-50',
            'indigo' => 'eb-text-indigo-600 eb-ring-indigo-500/30 eb-bg-indigo-50',
            'violet' => 'eb-text-violet-600 eb-ring-violet-500/30 eb-bg-violet-50',
            'purple' => 'eb-text-purple-600 eb-ring-purple-500/30 eb-bg-purple-50',
            'fuchsia' => 'eb-text-fuchsia-600 eb-ring-fuchsia-500/30 eb-bg-fuchsia-50',
            'pink' => 'eb-text-pink-600 eb-ring-pink-500/30 eb-bg-pink-50',
            'rose' => 'eb-text-rose-600 eb-ring-rose-500/30 eb-bg-rose-50',
            default => 'eb-text-eb-600 eb-ring-eb-500/30 eb-bg-eb-50',
        };
    }
}
