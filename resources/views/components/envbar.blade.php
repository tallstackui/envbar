<div @class([
        'eb-border-l-6',
        'eb-top-0 eb-p-3 eb-z-50',
        'eb-sticky' => $configuration['fixed'],
        $configuration['colors']
    ]) x-data="envbar()" x-show="show">
    <div class="eb-flex eb-items-center eb-ml-2 eb-gap-1">
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            @lang('envbar::messages.you-are-in-the')
            <x-envbar::badge :$configuration>
                local
            </x-envbar::badge>
            @lang('envbar::messages.environment')
            <x-envbar::branch class="eb-w-4 eb-h-4" gray />
        </div>
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-1">
            <div class="eb-inline-flex eb-items-center eb-gap-1">
                @lang('envbar::messages.the-current-source-is', ['source' => true ? 'release' : 'branch'])
                <x-envbar::badge>feat/foobar</x-envbar::badge>
            </div>
        </div>
        <div class="eb-flex eb-absolute eb-right-1 eb-items-center">
            @if ($configuration['closable']['enabled'])
                <button type="button" x-on:click="close(@js($configuration['closable']['timeout']))">
                    <x-envbar::icons.x-mark class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
