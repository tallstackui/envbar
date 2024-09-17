<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EnvoyerProvider extends AbstractProvider
{
    protected array $keys = [
        'token',
        'project_id',
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
            ->get('https://envoyer.io/api/projects/'.$this->configuration->get('project_id'));

        if ($response->ok()) {
            Cache::put($this->cacheKey(), $tag = $response->json('project.last_deployed_branch'), now()->addDays($this->configuration->get('cached_for', 1)));

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
        return 'envoyer';
    }
}
