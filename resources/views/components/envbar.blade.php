<div @class([
        'eb-border-l-6',
        'eb-top-0 eb-z-50',
        'eb-p-0.5' => $configuration['size'] === 'xs',
        'eb-p-1' => $configuration['size'] === 'sm',
        'eb-p-3' => $configuration['size'] === 'md',
        'eb-p-4' => $configuration['size'] === 'lg',
        'eb-p-5' => $configuration['size'] === 'xl',
        'eb-sticky' => $configuration['fixed'],
        $colors['background']
    ]) id="envbar">
    <div class="eb-flex eb-flex-wrap eb-items-center eb-space-x-1 eb-gap-1">
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.laravel @class($colors['icons']) />
            <p>@lang('envbar::messages.environment')</p>
            <x-envbar::badge :size="$configuration['size']">
                {{ $environment['environment'] }}
            </x-envbar::badge>
        </div>
        @if ($environment['branch'] !== null)
        <div class="eb-flex eb-flex-row eb-items-center eb-gap-1">
            <x-envbar::icons.fork @class($colors['icons']) />
            <div class="eb-inline-flex eb-items-center">
                <p>@lang('envbar::messages.branch')</p>
                <x-envbar::badge :size="$configuration['size']">{{ $environment['branch'] }}</x-envbar::badge>
            </div>
        </div>
        @endif
        @if ($environment['release'] !== null)
        <div class="eb-inline-flex eb-items-center eb-gap-1">
            <x-envbar::icons.tag @class($colors['icons']) />
            <p>@lang('envbar::messages.release')</p>
            <x-envbar::badge :size="$configuration['size']">{{ $environment['release'] }}</x-envbar::badge>
        </div>
        @endif
        @if ($configuration['warning_message'])
            <x-envbar::icons.exclamation-circle />
            <div>
                {!! $configuration['warning_message'] !!}
            </div>
        @endif
        {{-- Right Side --}}
        <div class="eb-flex eb-items-center eb-absolute eb-right-2">
            @if ($configuration['tailwind_breaking_points'])
            <div class="eb-items-center eb-gap-1">
                <x-envbar::badge :size="$configuration['size']"><span id="envbar-resolution"></span></x-envbar::badge>
            </div>
            @endif
            @if ($configuration['closable']['enabled'])
                <button onclick="window.hide()" dusk="envbar_close_button">
                    <x-envbar::icons.x class="eb-h-4 eb-w-4" />
                </button>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => window.$envbar(@js($configuration)).init());
    document.addEventListener('livewire:navigated', () => window.$envbar(@js($configuration)).init());

    (function() {
        window.hide = () => window.$envbar(@js($configuration)).close();
    })();
</script>
