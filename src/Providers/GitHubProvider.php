<?php

namespace TallStackUi\EnvBar\Providers;

class GitHubProvider extends AbstractProvider
{
    protected array $keys = [
        'repository',
        'username',
        'token',
    ];

    /**
     * {@inheritDoc}
     */
    public function fetch(): ?string
    {
        $this->validate();

        return 'GitHub';
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'github';
    }
}
