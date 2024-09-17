<?php

namespace TallStackUi\EnvBar\Compilers;

use Exception;
use TallStackUi\EnvBar\Compilers\Colors\Colors;
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
     * @return array|string[]
     *
     * @throws Exception
     */
    public function __invoke(): array
    {
        $variables = ['configuration', 'colors', 'environment'];

        foreach ([
            'size',
            'fixed',
            'closable',
            'warning_message',
            'tailwind_breaking_points',
        ] as $method) {
            // When the method exists in this class, with the same name as
            // the configuration, it indicates that we are performing a
            // possible mutation, analysis or change of the default value.
            $variables['configuration'][$method] = method_exists($this, $method)
                ? $this->{$method}()
                : config("envbar.{$method}");
        }

        $variables['colors']['background'] = Colors::background();
        $variables['colors']['icons'] = Colors::icons();

        $variables['environment'] = [
            'provider' => config('envbar.provider'),
            'branch' => app(GitProvider::class)->fetch(),
            'release' => $this->provider(),
            'environment' => app()->environment(),
        ];

        return $variables;
    }

    /**
     * Fetch the provider.
     *
     * @throws Exception
     */
    private function provider(): ?string
    {
        return match (config('envbar.provider')) {
            'github' => app(GitHubProvider::class)->fetch(),
            'bitbucket' => app(BitBucketProvider::class)->fetch(),
            'envoyer' => app(EnvoyerProvider::class)->fetch(),
            default => null,
        };
    }

    /**
     * Determine if the EnvBar will use TailwindCSS Breaking Point feature.
     */
    private function tailwind_breaking_points(): bool
    {
        return file_exists(base_path('tailwind.config.js')) && config('envbar.tailwind_breaking_points');
    }
}
