<?php

use Illuminate\Support\Facades\File;
use TallStackUi\EnvBar\Providers\AbstractProvider;
use TallStackUi\EnvBar\Providers\GitProvider;

arch('should have all needed methods')
    ->expect(GitProvider::class)
    ->toHaveMethods(['fetch', 'provider']);

arch('should extend AbstractProvider')
    ->expect(GitProvider::class)
    ->toExtend(AbstractProvider::class);

it('reads the branch name without the trailing newline', function () {
    File::shouldReceive('get')->with(base_path('.git/HEAD'))->andReturn("ref: refs/heads/feature/envbar\n");

    expect(app(GitProvider::class)->fetch())->toBe('feature/envbar');
});

it('returns null on a detached HEAD', function () {
    File::shouldReceive('get')->andReturn("9311f15a1f5e4a0d2f8e7c6b5a4938271605f4e3\n");

    expect(app(GitProvider::class)->fetch())->toBeNull();
});

it('returns null when the HEAD file is unreadable', function () {
    File::shouldReceive('get')->andThrow(new RuntimeException('missing'));

    expect(app(GitProvider::class)->fetch())->toBeNull();
});
