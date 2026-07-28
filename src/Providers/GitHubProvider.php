<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Http;

class GitHubProvider extends AbstractProvider
{
    /** @var array<int, string> */
    protected array $keys = [
        'token',
        'repository',
    ];

    /**
     * {@inheritDoc}
     */
    public function fetch(): ?string
    {
        return $this->release(fn () => Http::withToken($this->configuration('token'))
            ->get('https://api.github.com/repos/'.$this->configuration('repository').'/tags'), '0.name');
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'github';
    }
}
