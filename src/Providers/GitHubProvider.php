<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GitHubProvider extends AbstractProvider
{
    protected array $keys = [
        'token',
        'repository',
    ];

    /**
     * {@inheritDoc}
     */
    public function fetch(): ?string
    {
        $this->validate();

        return Cache::remember($this->cacheKey(), now()->addDays($this->configuration->get('cached_for', 1)), function (): ?string {
            $response = Http::withToken($this->configuration->get('token'))
                ->get('https://api.github.com/repos/'.$this->configuration->get('repository').'/tags');

            if ($response->ok()) {
                return $response->collect()->first()['name'];
            }

            return null;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'github';
    }
}
