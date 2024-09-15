<?php

return [
    'enabled' => true,

    'environments' => [
        'local',
        'sandbox',
        'staging',
        // 'production'
    ],

    'colors' => [
        'local' => 'green',
        'sandbox' => 'yellow',
        'staging' => 'blue',
        'production' => 'red',
    ],

    'ignore_on' => [
        '/horizon',
        '/telescope',
    ],

    'for_authenticated_users' => [
        'enabled' => true,

        'guard' => 'web',
    ],

    'on_mobile' => false,

    'providers' => [
        'github' => [
            'enabled' => true,
        ],
        'bitbucket' => [
            'enabled' => true,
        ],
    ],
];
