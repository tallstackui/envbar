<span @class([
        'eb-inline-flex eb-items-center eb-rounded-full eb-px-2 eb-py-1 eb-text-sm eb-font-medium eb-ring-1 eb-ring-inset',
        $colors()
    ])>
    {{ $text ?? $slot }}
</span>
