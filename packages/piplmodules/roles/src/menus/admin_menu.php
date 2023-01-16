<?php

$adminMenu[5] = [
    'icon' => 'table',
    'list_head' => [
        'name' => trans('Roles::roles.roles'),
        'link' => action('Piplmodules\Roles\Controllers\RolesController@index'),
    ],
    'list_tree'=> [
        0 => [
            'name' => trans('Roles::roles.all').' '.trans('Roles::roles.roles'),
            'link' => action('Piplmodules\Roles\Controllers\RolesController@index'),
        ],
        1 => [
            'name' => trans('Roles::roles.create').' '.trans('Roles::roles.role'),
            'link' => action('Piplmodules\Roles\Controllers\RolesController@create'),
        ]

    ]
];