<div @class([
        'eb-top-0 eb-p-2 eb-z-50',
        'eb-sticky' => $fixed,
        $backgroundColor
    ]) x-data="envbar()" x-show="show">
    <div class="eb-flex eb-justify-between eb-items-center">
        <div>
            Foo
        </div>
        <div>
            Bar
        </div>
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-2">
            <div>
                Baz
            </div>
            @if ($closable['enabled'])
                <button type="button" x-on:click="close(@js($closable['timeout']))">
                    <x-envbar::icons.x-mark class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>
