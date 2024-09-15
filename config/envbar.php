<?php

return [
    'enabled' => true,

    'disable_on_tests' => false,

    'fixed' => true,

    'tailwind_breaking_points' => true,

    // TODO: should only be applied if AlpineJS is loaded.
    'closable' => [
        'enabled' => true,

        'timeout' => null,
    ],

    // TODO: we need to validate this.
    'environments' => [
        'local' => 'green',
        'sandbox' => 'yellow',
        'staging' => 'blue',
        // 'production' => 'red',
    ],

    'ignore_on' => [
        'pulse/*',
        'horizon/*',
        'telescope/*',
    ],

    'for_authenticated_users' => [
        'enabled' => true,

        'guard' => 'web',
    ],

    'on_mobile' => false,

    'providers' => [
        'github' => [
            'repository' => env('ENVBAR_GITHUB_REPOSITORY'),
            'username' => env('ENVBAR_GITHUB_USERNAME'),
            'token' => env('ENVBAR_GITHUB_TOKEN'),
        ],
        'bitbucket' => [
            'workspace' => env('ENVBAR_BITBUCKET_WORKSPACE'),
            'repository' => env('ENVBAR_BITBUCKET_REPOSITORY'),
            'username' => env('ENVBAR_BITBUCKET_USERNAME'),
            'token' => env('ENVBAR_BITBUCKET_TOKEN'),
        ],
    ],
];
