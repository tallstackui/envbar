<div @class([
        'eb-text-sm eb-font-medium eb-mx-1.5 eb-rounded-xl eb-shadow-inner',
        'eb-px-1 eb-p' => $size === 'xs',
        'eb-px-1 eb-p-0.5' => $size === 'sm',
        'eb-px-2.5 eb-py-0.5' => $size === 'md' || $size === 'lg' || $size === 'xl',
    $color])>
    @if ($icon)
        <div>
            {{ $icon }}
        </div>
    @endif
        <b>{{ $text ?? $slot }}</b>
</div>
