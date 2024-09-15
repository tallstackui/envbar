<div @class([
        'eb-border-l-6',
        'eb-top-0 eb-p-3 eb-z-50',
        'eb-sticky' => $configuration['fixed'],
        $configuration['colors']
    ]) x-data="envbar()" x-show="show">
    <div class="eb-flex eb-flex-wrap eb-items-center eb-ml-2 eb-gap-1">
        {{-- Environment --}}
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.laravel class="eb-h-6 eb-w-6 eb-text-green-700" />
            <p>@lang('envbar::messages.environment')</p>
            <x-envbar::badge>
                Local
            </x-envbar::badge>
            <x-envbar::icons.fork class="eb-h-6 eb-w-6 eb-text-green-700" />
        </div>
        {{-- Branch --}}
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-1">
            <div class="eb-inline-flex eb-items-center">
                <p>@lang('envbar::messages.branch')</p>
                <x-envbar::badge>feat/foobar</x-envbar::badge>
            </div>
        </div>
        {{-- Release --}}
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.tag class="eb-h-4 eb-w-4 eb-text-green-700" />
            <p>@lang('envbar::messages.release')</p>
            <x-envbar::badge>v2.11.23</x-envbar::badge>
        </div>
        {{-- Right Side --}}
        <div class="eb-flex eb-items-center eb-absolute eb-right-2">
            <x-envbar::badge>XL</x-envbar::badge>
            @if ($configuration['closable']['enabled'])
                <button type="button" x-on:click="close(@js($configuration['closable']['timeout']))">
                    <x-envbar::icons.x class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
