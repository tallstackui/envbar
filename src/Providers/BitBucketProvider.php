<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BitBucketProvider extends AbstractProvider
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
                ->get('https://api.bitbucket.org/2.0/repositories/'.$this->configuration->get('repository').'/refs/tags', [
                    'sort' => 'target.date',
                ]);

            if ($response->ok()) {
                return rescue(fn () => $response->collect()->get('values')[0]['name'], report: false);
            }

            return null;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'bitbucket';
    }
}
