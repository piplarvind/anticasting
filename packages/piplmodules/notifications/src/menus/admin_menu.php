<?php

$adminMenu[5] = [
    'icon' => 'table',
    'list_head' => [
        'name' => trans('Notifications::notifications.notifications'),
        'link' => action('Piplmodules\Notifications\Controllers\NotificationsController@index'),
    ],
    'list_tree'=> [
        0 => [
            'name' => trans('Notifications::notifications.all').' '.trans('Notifications::notifications.notifications'),
            'link' => action('Piplmodules\Notifications\Controllers\NotificationsController@index'),
        ],
        1 => [
            'name' => trans('Notifications::notifications.create').' '.trans('Notifications::notifications.notification'),
            'link' => action('Piplmodules\Notifications\Controllers\NotificationsController@create'),
        ]

    ]
];
