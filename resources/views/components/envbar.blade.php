@php
    $id = uniqid();
@endphp

<div @class([
        'eb-border-l-6',
        'eb-top-0 eb-p-3 eb-z-50',
        'eb-sticky' => $configuration['fixed'],
        $configuration['background']
    ]) x-data="envbar(@js($configuration))" x-show="show" id="envbar-{{ $id }}">
    <div class="eb-flex eb-flex-wrap eb-items-center eb-space-x-2 eb-gap-1">
        {{-- Environment --}}
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.laravel @class($configuration['icons']) />
            <p>@lang('envbar::messages.environment')</p>
            <x-envbar::badge>
                Local
            </x-envbar::badge>
            <x-envbar::icons.fork @class($configuration['icons']) />
        </div>
        {{-- Branch --}}
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-1">
            <div class="eb-inline-flex eb-items-center">
                <p>@lang('envbar::messages.branch')</p>
                <x-envbar::badge>feat/foobar</x-envbar::badge>
            </div>
        </div>
        {{-- Last Release --}}
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.tag @class($configuration['icons']) />
            <p>@lang('envbar::messages.release')</p>
            <x-envbar::badge>v2.11.23</x-envbar::badge>
        </div>
        {{-- Right Side --}}
        <div class="eb-flex eb-items-center eb-absolute eb-right-2" id="envbar-{{ $id }}-right-side">
            @if ($configuration['tailwind_breaking_points'])
            <div class="eb-items-center eb-gap-1">
                <x-envbar::badge><span x-text="resolution"></span></x-envbar::badge>
            </div>
            @endif
            @if ($configuration['closable']['enabled'])
                <button type="button" x-on:click="close()">
                    <x-envbar::icons.x class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
