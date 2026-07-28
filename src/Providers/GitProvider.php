<?php

namespace TallStackUi\EnvBar\Providers;

use Illuminate\Support\Facades\File;

class GitProvider extends AbstractProvider
{
    /**
     * {@inheritDoc}
     */
    public function fetch(): ?string
    {
        $branch = rescue(fn () => File::get(base_path('.git/HEAD')), report: false);

        if ($branch === null) {
            return null;
        }

        $string = str($branch);

        if (! $string->contains('ref: refs/heads/')) {
            return null;
        }

        // .git/HEAD is written with a trailing newline.
        return $string->replace('ref: refs/heads/', '')->trim()->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function provider(): string
    {
        return 'git';
    }
}
