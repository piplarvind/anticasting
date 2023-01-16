<?php

$adminMenu[8] = [
    'icon' => 'table',
    'list_head' => [
        'name' => trans('Pages::pages.static_pages'),
        'link' => action('Piplmodules\Pages\Controllers\PagesController@index'),
    ]
];

////old
//$adminMenu[8] = [
//        'icon' => 'table',
//        'list_head' => [
//                'name' => trans('Pages::pages.pages'),
//                'link' => '/'.App::getLocale().'/admin/pages',
//        ],
//        'list_tree'=> [
//                0 => [
//                    'name' => trans('Pages::pages.all').' '.trans('Pages::pages.pages'),
//                    'link' => '/'.App::getLocale().'/admin/pages/dynamic',
//                ],
//                1 => [
//                    'name' => trans('Pages::pages.create').' '.trans('Pages::pages.page'),
//                    'link' => '/'.App::getLocale().'/admin/pages/create',
//                ]
//        ]
//];