<?php

namespace TallStackUi\EnvBar\Providers;

use Exception;
use Illuminate\Support\Collection;

abstract class AbstractProvider
{
    /** The required keys for the provider. */
    protected array $keys = [];

    public function __construct(protected ?Collection $configuration = null)
    {
        $this->configuration = collect(config('envbar.providers.'.$this->provider()));
    }

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
            if (blank($this->configuration->get($key))) {
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
}
