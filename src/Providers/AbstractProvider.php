<?php

namespace TallStackUi\EnvBar\Providers;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

abstract class AbstractProvider
{
    /** @var array<int, string> The required keys for the provider. */
    protected array $keys = [];

    /**
     * Get the provider name.
     */
    abstract public function provider(): string;

    /**
     * Fetch the provider data.
     *
     * @throws Exception
     */
    abstract public function fetch(): ?string;

    /**
     * Run the basic provider validation.
     *
     * @throws Exception
     */
    public function validate(): void
    {
        if (config('envbar.provider') !== ($provider = $this->provider())) {
            throw new Exception("The provider was not set to: {$provider}.");
        }

        if ($this->keys === []) {
            return;
        }

        $title = __('envbar::providers.'.$provider, locale: 'en');

        foreach ($this->keys as $key) {
            if (blank($this->configuration($key))) {
                throw new Exception("The $title provider requires the {$key} key to be set.");
            }
        }
    }

    /**
     * Get the cache key for the provider.
     */
    public function cacheKey(): string
    {
        return 'envbar::'.$this->provider().'::release';
    }

    /**
     * Get the cache key that short-circuits requests after a failed fetch.
     */
    public function failureCacheKey(): string
    {
        return $this->cacheKey().'::failed';
    }

    /**
     * Get a configuration value of the provider.
     */
    protected function configuration(string $key, mixed $default = null): mixed
    {
        return data_get(config('envbar.providers.'.$this->provider()), $key, $default);
    }

    /**
     * Resolve the release through the cache, skipping the API while a recent fetch is known to have failed.
     *
     * @param  callable(): Response  $request
     *
     * @throws Exception
     */
    protected function release(callable $request, string $key): ?string
    {
        $this->validate();

        if (Cache::has($this->cacheKey())) {
            $cached = Cache::get($this->cacheKey());

            return is_string($cached) ? $cached : null;
        }

        if (Cache::has($this->failureCacheKey())) {
            return null;
        }

        $response = $request();

        if ($response->ok()) {
            $tag = $response->json($key);
            $tag = is_string($tag) ? $tag : null;

            Cache::put($this->cacheKey(), $tag, now()->addDays((int) $this->configuration('cached_for', 1)));

            return $tag;
        }

        Cache::put($this->failureCacheKey(), true, now()->addMinutes((int) config('envbar.provider_failure_cached_for', 5)));

        $response->throw();

        return null;
    }
}
