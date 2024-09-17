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

        return Cache::remember($this->cacheKey(), now()->addDays($this->configuration->get('cached_for', 1)), function (): ?string {
            $response = Http::withToken($this->configuration->get('token'))
                ->get('https://envoyer.io/api/projects/'.$this->configuration->get('project_id'));

            return $response->failed()
                ? null
                : $response->json('project.last_deployed_branch');
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'envoyer';
    }
}
