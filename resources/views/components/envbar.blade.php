<div @class([
        'eb-border-l-6',
        'eb-top-0 eb-p-3 eb-z-50',
        'eb-sticky' => $configuration['fixed'],
        $configuration['colors']
    ]) x-data="envbar()" x-show="show">
    <div class="eb-flex eb-items-center eb-ml-2 eb-gap-1">
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.laravel class="eb-h-6 eb-w-6 eb-text-green-700" />
            @lang('envbar::messages.environment')
            <x-envbar::badge>
                local
            </x-envbar::badge>
            <x-envbar::icons.fork class="eb-h-6 eb-w-6 eb-text-green-700" />
        </div>
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-1">
            <div class="eb-inline-flex eb-items-center eb-gap-1">
                @lang('envbar::messages.branch')
                <x-envbar::badge>feat/foobar</x-envbar::badge>
            </div>
        </div>
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.tag class="eb-h-4 eb-w-4 eb-text-green-700" />
            @lang('envbar::messages.release')
            <x-envbar::badge>v2.11.23</x-envbar::badge>
        </div>
        <div class="eb-flex eb-absolute eb-right-1 eb-items-center">
            <x-envbar::badge>XL</x-envbar::badge>
            @if ($configuration['closable']['enabled'])
                <button type="button" x-on:click="close(@js($configuration['closable']['timeout']))">
                    <x-envbar::icons.x class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
