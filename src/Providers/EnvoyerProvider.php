<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Http;

class EnvoyerProvider extends AbstractProvider
{
    /** @var array<int, string> */
    protected array $keys = [
        'token',
        'project_id',
    ];

    /**
     * {@inheritDoc}
     */
    public function fetch(): ?string
    {
        return $this->release(fn () => Http::withToken($this->configuration('token'))
            ->get('https://envoyer.io/api/projects/'.$this->configuration('project_id')), 'project.last_deployed_branch');
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'envoyer';
    }
}
