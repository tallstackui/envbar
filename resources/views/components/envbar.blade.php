<div @class([
        'eb-border-l-4',
        'eb-top-0 eb-p-2 eb-z-50',
        'eb-sticky' => $configuration['fixed'],
        $configuration['background']
    ]) x-data="envbar()" x-show="show">
    <div class="eb-flex eb-justify-between eb-items-center eb-ml-2">
        <div class="eb-inline-flex eb-items-center gap-2">
            @lang('envbar::messages.you-are-in-the')
            <x-envbar::badge :$configuration>
                local
            </x-envbar::badge>
        </div>
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-2">
            <div>
                @lang('envbar::messages.the-current-source-is', ['source' => true ? 'release' : 'branch'])
            </div>
            @if ($configuration['closable']['enabled'])
                <button type="button" x-on:click="close(@js($configuration['closable']['timeout']))">
                    <x-envbar::icons.x-mark class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
