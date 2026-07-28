<?php

namespace TallStackUi\EnvBar\Compilers;

class Colors
{
    /**
     * Tailwind scans this file through the `@source` directive, so every class must
     * stay a complete literal. Building them by concatenation drops them from the bundle.
     */
    private const MAP = [
        'green' => [
            'background' => 'eb:border-l-green-500 eb:text-green-700 eb:bg-green-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-green-700',
            'badge' => 'eb:text-green-800 eb:bg-green-300',
        ],
        'yellow' => [
            'background' => 'eb:border-l-yellow-500 eb:text-yellow-700 eb:bg-yellow-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-yellow-700',
            'badge' => 'eb:text-yellow-800 eb:bg-yellow-300',
        ],
        'blue' => [
            'background' => 'eb:border-l-blue-500 eb:text-blue-700 eb:bg-blue-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-blue-700',
            'badge' => 'eb:text-blue-800 eb:bg-blue-300',
        ],
        'red' => [
            'background' => 'eb:border-l-red-500 eb:text-red-700 eb:bg-red-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-red-700',
            'badge' => 'eb:text-red-800 eb:bg-red-300',
        ],
        'slate' => [
            'background' => 'eb:border-l-slate-500 eb:text-slate-700 eb:bg-slate-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-slate-700',
            'badge' => 'eb:text-slate-800 eb:bg-slate-300',
        ],
        'gray' => [
            'background' => 'eb:border-l-gray-500 eb:text-gray-700 eb:bg-gray-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-gray-700',
            'badge' => 'eb:text-gray-800 eb:bg-gray-300',
        ],
        'zinc' => [
            'background' => 'eb:border-l-zinc-500 eb:text-zinc-700 eb:bg-zinc-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-zinc-700',
            'badge' => 'eb:text-zinc-800 eb:bg-zinc-300',
        ],
        'neutral' => [
            'background' => 'eb:border-l-neutral-500 eb:text-neutral-700 eb:bg-neutral-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-neutral-700',
            'badge' => 'eb:text-neutral-800 eb:bg-neutral-300',
        ],
        'stone' => [
            'background' => 'eb:border-l-stone-500 eb:text-stone-700 eb:bg-stone-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-stone-700',
            'badge' => 'eb:text-stone-800 eb:bg-stone-300',
        ],
        'orange' => [
            'background' => 'eb:border-l-orange-500 eb:text-orange-700 eb:bg-orange-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-orange-700',
            'badge' => 'eb:text-orange-800 eb:bg-orange-300',
        ],
        'amber' => [
            'background' => 'eb:border-l-amber-500 eb:text-amber-700 eb:bg-amber-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-amber-700',
            'badge' => 'eb:text-amber-800 eb:bg-amber-300',
        ],
        'lime' => [
            'background' => 'eb:border-l-lime-500 eb:text-lime-700 eb:bg-lime-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-lime-700',
            'badge' => 'eb:text-lime-800 eb:bg-lime-300',
        ],
        'emerald' => [
            'background' => 'eb:border-l-emerald-500 eb:text-emerald-700 eb:bg-emerald-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-emerald-700',
            'badge' => 'eb:text-emerald-800 eb:bg-emerald-300',
        ],
        'teal' => [
            'background' => 'eb:border-l-teal-500 eb:text-teal-700 eb:bg-teal-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-teal-700',
            'badge' => 'eb:text-teal-800 eb:bg-teal-300',
        ],
        'cyan' => [
            'background' => 'eb:border-l-cyan-500 eb:text-cyan-700 eb:bg-cyan-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-cyan-700',
            'badge' => 'eb:text-cyan-800 eb:bg-cyan-300',
        ],
        'sky' => [
            'background' => 'eb:border-l-sky-500 eb:text-sky-700 eb:bg-sky-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-sky-700',
            'badge' => 'eb:text-sky-800 eb:bg-sky-300',
        ],
        'indigo' => [
            'background' => 'eb:border-l-indigo-500 eb:text-indigo-700 eb:bg-indigo-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-indigo-700',
            'badge' => 'eb:text-indigo-800 eb:bg-indigo-300',
        ],
        'violet' => [
            'background' => 'eb:border-l-violet-500 eb:text-violet-700 eb:bg-violet-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-violet-700',
            'badge' => 'eb:text-violet-800 eb:bg-violet-300',
        ],
        'purple' => [
            'background' => 'eb:border-l-purple-500 eb:text-purple-700 eb:bg-purple-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-purple-700',
            'badge' => 'eb:text-purple-800 eb:bg-purple-300',
        ],
        'fuchsia' => [
            'background' => 'eb:border-l-fuchsia-500 eb:text-fuchsia-700 eb:bg-fuchsia-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-fuchsia-700',
            'badge' => 'eb:text-fuchsia-800 eb:bg-fuchsia-300',
        ],
        'pink' => [
            'background' => 'eb:border-l-pink-500 eb:text-pink-700 eb:bg-pink-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-pink-700',
            'badge' => 'eb:text-pink-800 eb:bg-pink-300',
        ],
        'rose' => [
            'background' => 'eb:border-l-rose-500 eb:text-rose-700 eb:bg-rose-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-rose-700',
            'badge' => 'eb:text-rose-800 eb:bg-rose-300',
        ],
        'primary' => [
            'background' => 'eb:border-l-envbar-500 eb:text-envbar-700 eb:bg-envbar-100',
            'icons' => 'eb:h-6 eb:w-6 eb:text-envbar-700',
            'badge' => 'eb:text-envbar-800 eb:bg-envbar-300',
        ],
    ];

    /**
     * Get the background colors: border and text colors.
     */
    public static function background(): string
    {
        return self::resolve('background');
    }

    /**
     * Get the icon colors: size and text.
     */
    public static function icons(): string
    {
        return self::resolve('icons');
    }

    /**
     * Get the badge colors: text and background.
     */
    public static function badge(): string
    {
        return self::resolve('badge');
    }

    /**
     * Resolve a block of classes for the current environment color.
     */
    private static function resolve(string $block): string
    {
        $color = data_get(config('envbar.environments'), app()->environment(), 'primary');

        if (! is_string($color) || ! isset(self::MAP[$color])) {
            $color = 'primary';
        }

        return self::MAP[$color][$block];
    }
}
