<div @class([
        'eb-text-sm eb-font-medium eb-px-2.5 eb-py-0.5 eb-mx-1.5 eb-rounded-xl eb-shadow-inner',
        $colors()
    ])>
    @if ($icon)
        <div>
            {{ $icon }}
        </div>
    @endif
        <b>{{ $text ?? $slot }}</b>
</div>
