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

        if (Cache::has($this->cacheKey())) {
            return Cache::get($this->cacheKey());
        }

        $response = Http::withToken($this->configuration->get('token'))
            ->get('https://api.github.com/repos/'.$this->configuration->get('repository').'/tags');

        if ($response->ok()) {
            Cache::put($this->cacheKey(), $tag = $response->json('0.name'), now()->addDays($this->configuration->get('cached_for', 1)));

            return $tag;
        }

        $response->throw();

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'github';
    }
}
