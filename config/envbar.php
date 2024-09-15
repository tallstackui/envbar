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

    'on_mobile' => true,

    'on_specific_browsers' => [],

    'providers' => [
        'github' => [
            'enabled' => true,
        ],
        'bitbucket' => [
            'enabled' => true,
        ],
    ],
];
