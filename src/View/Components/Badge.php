<?php

namespace TallStackUi\EnvBar\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentSlot;

class Badge extends BaseComponent
{
    public function __construct(
        public ?string $text = null,
        public ?string $size = null,
        public ComponentSlot|string|null $icon = null,
    ) {
        $this->size = match ($this->size) {
            'xs' => 'xs',
            'sm' => 'sm',
            'lg' => 'lg',
            'xl' => 'xl',
            default => 'md',
        };
    }

    public function blade(): View
    {
        return view('envbar::components.badge', ['color' => $this->colors()]);
    }

    /**
     * Set the colors.
     */
    private function colors(): string
    {
        return match (data_get(config('envbar.environments'), app()->environment(), 'primary')) {
            'green' => 'eb-text-green-800 eb-bg-green-300',
            'yellow' => 'eb-text-yellow-800 eb-bg-yellow-300',
            'blue' => 'eb-text-blue-800 eb-bg-blue-300',
            'red' => 'eb-text-red-800 eb-bg-red-300',
            'slate' => 'eb-text-slate-800 eb-bg-slate-300',
            'gray' => 'eb-text-gray-800 eb-bg-gray-300',
            'zinc' => 'eb-text-zinc-800 eb-bg-zinc-300',
            'neutral' => 'eb-text-neutral-800 eb-bg-neutral-300',
            'stone' => 'eb-text-stone-800 eb-bg-stone-300',
            'orange' => 'eb-text-orange-800 eb-bg-orange-300',
            'amber' => 'eb-text-amber-800 eb-bg-amber-300',
            'lime' => 'eb-text-lime-800 eb-bg-lime-300',
            'emerald' => 'eb-text-emerald-800 eb-bg-emerald-300',
            'teal' => 'eb-text-teal-800 eb-bg-teal-300',
            'cyan' => 'eb-text-cyan-800 eb-bg-cyan-300',
            'sky' => 'eb-text-sky-800 eb-bg-sky-300',
            'indigo' => 'eb-text-indigo-800 eb-bg-indigo-300',
            'violet' => 'eb-text-violet-800 eb-bg-violet-300',
            'purple' => 'eb-text-purple-800 eb-bg-purple-300',
            'fuchsia' => 'eb-text-fuchsia-800 eb-bg-fuchsia-300',
            'pink' => 'eb-text-pink-800 eb-bg-pink-300',
            'rose' => 'eb-text-rose-800 eb-bg-rose-300',
            default => 'eb-text-envbar-800 eb-bg-envbar-300',
        };
    }
}
