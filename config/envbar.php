<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General Status
    |--------------------------------------------------------------------------
    |
    | Determines if the EnvBar is enabled.
    |
    */
    'enabled' => env('ENVBAR_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Disable on Tests
    |--------------------------------------------------------------------------
    |
    | Determines if the EnvBar should be disabled when running tests.
    |
    */
    'disable_on_tests' => env('ENVBAR_DISABLE_ON_TESTS', true),

    /*
    |--------------------------------------------------------------------------
    | Fixed
    |--------------------------------------------------------------------------
    |
    | Determines the size of the EnvBar. Allowed: xs, sm, md, lg, xl.
    |
    */
    'size' => env('ENVBAR_SIZE', 'md'),

    /*
    |--------------------------------------------------------------------------
    | Fixed
    |--------------------------------------------------------------------------
    |
    | Determines if the EnvBar will be displayed as fixed on top.
    |
    */
    'fixed' => env('ENVBAR_FIXED', true),

    /*
    |--------------------------------------------------------------------------
    | Tailwind Breaking Points
    |--------------------------------------------------------------------------
    |
    | Determines if the EnvBar will display the Tailwind CSS breaking points.
    | It will only work if the AlpineJS was loaded on the page and also if the
    | Tailwind CSS configuration file (tailwind.config.js) exists on the base path.
    |
    */
    'tailwind_breaking_points' => env('ENVBAR_TAILWIND_BREAKING_POINTS', true),

    /*
    |--------------------------------------------------------------------------
    | Custom Warning Message
    |--------------------------------------------------------------------------
    |
    | Allows you to set a custom warning message to be displayed on the EnvBar.
    | Behind the scenes, it will be applied using {!! !!} to allow HTML content.
    |
    */
    'warning_message' => env('ENVBAR_WARNING_MESSAGE'),

    /*
    |--------------------------------------------------------------------------
    | Closable Effect
    |--------------------------------------------------------------------------
    |
    | Only work if the AlpineJS was loaded on the page.
    */
    'closable' => [
        /*
        |--------------------------------------------------------------------------
        | General Status
        |--------------------------------------------------------------------------
        |
        | Controls if the closable effect is enabled.
        |
        */
        'enabled' => env('ENVBAR_CLOSABLE_ENABLED', true),

        /*
        |--------------------------------------------------------------------------
        | Timeout
        |--------------------------------------------------------------------------
        |
        | When set, the EnvBar will wait the set seconds to appear again.
        |
        */
        'timeout' => env('ENVBAR_CLOSABLE_TIMEOUT'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Environments
    |--------------------------------------------------------------------------
    |
    | Determines in which environments the EnvBar will be displayed and the colors.
    |
    */
    'environments' => [
        'local' => 'green',
        'staging' => 'yellow',
        'sandbox' => 'orange',
        // 'production' => 'red',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ignore on Specific Routes/Pages
    |--------------------------------------------------------------------------
    |
    | Allows you to do not display the EnvBar on specific pages. Behind the scenes,
    | this feature will use the `Request::is()` method to match the current request.
    |
    */
    'ignore_on' => [
        'pulse/*',
        'horizon/*',
        'telescope/*',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display for Authenticated Users
    |--------------------------------------------------------------------------
    |
    | Allows you to display the EnvBar only for specific authenticated users.
    | To work correctly, in addition to enabling this feature you must create a
    | Gate, similar to what is done to authenticate access to Horizon, but with
    | the gate key: envbar::view
    |
    */
    'for_authenticated_users' => [
        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        |
        | Controls the status.
        |
        */
        'enabled' => env('ENVBAR_FOR_AUTHENTICATED_USERS_ENABLED', false),

        /*
        |--------------------------------------------------------------------------
        | Guard
        |--------------------------------------------------------------------------
        |
        | Determine which guard should be used to check the authentication status.
        |
        */
        'guard' => 'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ignore on Mobiles
    |--------------------------------------------------------------------------
    |
    | Allows you to do not display the EnvBar on mobile devices.
    |
    */
    'on_mobile' => env('ENVBAR_ON_MOBILE', false),

    /*
    |--------------------------------------------------------------------------
    | Default Git Provider
    |--------------------------------------------------------------------------
    |
    | Determines the provider to be used to fetch the latest version of the application.
    | All keys inside "providers" is the supported values: github, bitbucket.
    |
    */
    'provider' => env('ENVBAR_PROVIDER'),

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | Determines the configuration for each provider.
    |
    */
    'providers' => [
        'github' => [
            'token' => env('ENVBAR_GITHUB_TOKEN'),
            'repository' => env('ENVBAR_GITHUB_REPOSITORY'),
            'cached_for' => env('ENVBAR_GITHUB_CACHED_FOR', 1),
        ],

        'bitbucket' => [
            'token' => env('ENVBAR_BITBUCKET_TOKEN'),
            'repository' => env('ENVBAR_BITBUCKET_REPOSITORY'),
            'cached_for' => env('ENVBAR_BITBUCKET_CACHED_FOR', 1),
        ],
    ],
];
