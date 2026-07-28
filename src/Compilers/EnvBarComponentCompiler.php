<?php

namespace TallStackUi\EnvBar\Compilers;

use TallStackUi\EnvBar\Providers\BitBucketProvider;
use TallStackUi\EnvBar\Providers\EnvoyerProvider;
use TallStackUi\EnvBar\Providers\GitHubProvider;
use TallStackUi\EnvBar\Providers\GitProvider;

// The idea of this class is to be a class that
// provides configurations for the component,
// since the component is used as anonymous.
class EnvBarComponentCompiler
{
    /**
     * Compiles the base component configurations.
     *
     * @return array{
     *     configuration: array<string, mixed>,
     *     colors: array<string, string>,
     *     environment: array<string, string|null>,
     * }
     */
    public function __invoke(): array
    {
        $configuration = [];

        foreach ([
            'size',
            'fixed',
            'links',
            'bottom',
            'closable',
            'warning_message',
            'tailwind_breaking_points',
        ] as $method) {
            // When the method exists in this class, with the same name as
            // the configuration, it indicates that we are performing a
            // possible mutation, analysis or change of the default value.
            $configuration[$method] = method_exists($this, $method)
                ? $this->{$method}()
                : config("envbar.{$method}");
        }

        return [
            'configuration' => $configuration,
            'colors' => [
                'background' => Colors::background(),
                'icons' => Colors::icons(),
            ],
            'environment' => [
                'provider' => $this->label(),
                'branch' => app(GitProvider::class)->fetch(),
                'release' => $this->release(),
                'environment' => app()->environment(),
            ],
        ];
    }

    /**
     * Fetch the latest release, degrading to null so a broken
     * provider never takes the whole application down.
     */
    private function release(): ?string
    {
        $provider = match (config('envbar.provider')) {
            'github' => GitHubProvider::class,
            'bitbucket' => BitBucketProvider::class,
            'envoyer' => EnvoyerProvider::class,
            default => null,
        };

        if ($provider === null) {
            return null;
        }

        return rescue(fn () => app($provider)->fetch(), null);
    }

    /**
     * Get the display name of the configured provider.
     */
    private function label(): ?string
    {
        $provider = config('envbar.provider');

        if (! is_string($provider) || blank($provider)) {
            return null;
        }

        $label = __($key = 'envbar::providers.'.$provider);

        return is_string($label) && $label !== $key ? $label : $provider;
    }

    /**
     * Determine if the EnvBar will use TailwindCSS Breaking Point feature.
     */
    private function tailwind_breaking_points(): bool
    {
        return file_exists(base_path('tailwind.config.js')) && (bool) config('envbar.tailwind_breaking_points');
    }

    /**
     * Format the links what will be displayed on the dropdown.
     *
     * @return array<int, array{name: string, url: string}>|null
     */
    private function links(): ?array
    {
        $links = array_values(array_filter(array_map(
            static fn (mixed $link): string => is_string($link) ? $link : '',
            (array) config('envbar.links')
        )));

        if ($links === []) {
            return null;
        }

        return array_map(static function (string $link): array {
            if (! str_contains($link, '|')) {
                return ['name' => $link, 'url' => $link];
            }

            [$name, $url] = explode('|', $link, 2);

            return ['name' => $name, 'url' => $url];
        }, $links);
    }
}
