<?php

namespace TallStackUi\EnvBar\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentSlot;

class Badge extends BaseComponent
{
    public function __construct(
        public ?string $text = null,
        public ComponentSlot|string|null $icon = null,
    ) {
        //
    }

    public function blade(): View
    {
        return view('envbar::components.badge');
    }

    /**
     * Set the colors.
     */
    public function colors(): string
    {
        return match (data_get(config('envbar.environments'), app()->environment(), 'primary')) {
            'green' => 'eb-text-green-800 eb-bg-green-200',
            'yellow' => 'eb-text-yellow-800 eb-bg-yellow-200',
            'blue' => 'eb-text-blue-800 eb-bg-blue-200',
            'red' => 'eb-text-red-800 eb-bg-red-200',
            'slate' => 'eb-text-slate-800 eb-bg-slate-200',
            'gray' => 'eb-text-gray-800 eb-bg-gray-200',
            'zinc' => 'eb-text-zinc-800 eb-bg-zinc-200',
            'neutral' => 'eb-text-neutral-800 eb-bg-neutral-200',
            'stone' => 'eb-text-stone-800 eb-bg-stone-200',
            'orange' => 'eb-text-orange-800 eb-bg-orange-200',
            'amber' => 'eb-text-amber-800 eb-bg-amber-200',
            'lime' => 'eb-text-lime-800 eb-bg-lime-200',
            'emerald' => 'eb-text-emerald-800 eb-bg-emerald-200',
            'teal' => 'eb-text-teal-800 eb-bg-teal-200',
            'cyan' => 'eb-text-cyan-800 eb-bg-cyan-200',
            'sky' => 'eb-text-sky-800 eb-bg-sky-200',
            'indigo' => 'eb-text-indigo-800 eb-bg-indigo-200',
            'violet' => 'eb-text-violet-800 eb-bg-violet-200',
            'purple' => 'eb-text-purple-800 eb-bg-purple-200',
            'fuchsia' => 'eb-text-fuchsia-800 eb-bg-fuchsia-200',
            'pink' => 'eb-text-pink-800 eb-bg-pink-200',
            'rose' => 'eb-text-rose-800 eb-bg-rose-200',
            default => 'eb-text-envbar-800 eb-bg-envbar-200',
        };
    }
}
