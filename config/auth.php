<?php
return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admin_users', // 修正
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admin_users', // 修正
        ],
    ],

    'providers' => [
        'admin_users' => [ // 修正
            'driver' => 'eloquent',
            'model' => App\Models\AdminUser::class, // 修正
        ],
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'admin_users' => [ // 修正
            'provider' => 'admin_users', // 修正
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
