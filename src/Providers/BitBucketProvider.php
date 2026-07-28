<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Http;

class BitBucketProvider extends AbstractProvider
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
            ->get('https://api.bitbucket.org/2.0/repositories/'.$this->configuration('repository').'/refs/tags', [
                'sort' => 'target.date',
            ]), 'values.0.name');
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'bitbucket';
    }
}
