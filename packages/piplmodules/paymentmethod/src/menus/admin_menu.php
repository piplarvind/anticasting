<?php

$adminMenu[3] = [
    'icon' => 'user',
    'list_head' => [
        'name' => trans('Users::users.admin'),
        'link' => action('Piplmodules\Users\Controllers\AdminController@index'),
    ],
    'list_tree'=> [
        0 => [
            'name' => trans('Users::users.all').' '.trans('Users::users.admin'),
            'link' => action('Piplmodules\Users\Controllers\AdminController@index'),
        ],
        1 => [
            'name' => trans('Users::users.create').' '.trans('Users::users.admin'),
            'link' => action('Piplmodules\Users\Controllers\AdminController@create'),
        ]
    ]
];

$adminMenu[4] = [
    'icon' => 'users',
    'list_head' => [
            'name' => trans('Users::users.users'),
        'link' => action('Piplmodules\Users\Controllers\UsersController@index'),
    ],
    'list_tree'=> [
        0 => [
            'name' => trans('Users::users.doctors'),
            'link' => action('Piplmodules\Users\Controllers\UsersController@index'),
        ],
//        1 => [
//            'name' => trans('Users::users.patients'),
//            'link' => action('Piplmodules\Users\Controllers\UsersController@indexPatients'),
//        ]

    ]
];