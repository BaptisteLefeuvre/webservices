<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/book' => [
            [['_route' => 'add_book', '_controller' => 'App\\Controller\\BookController::add'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'get_all_books', '_controller' => 'App\\Controller\\BookController::getAll'], null, ['GET' => 0], null, false, false, null],
        ],
        '/stock' => [[['_route' => 'add_stock', '_controller' => 'App\\Controller\\StockController::add'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/book/([^/]++)(?'
                    .'|(*:59)'
                    .'|/buy(?:/([^/]++))?(*:84)'
                    .'|(*:91)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        59 => [[['_route' => 'get_one_book', '_controller' => 'App\\Controller\\BookController::get'], ['id'], ['GET' => 0], null, false, true, null]],
        84 => [[['_route' => 'buy_book', 'stock' => null, '_controller' => 'App\\Controller\\BookController::buyBook'], ['id', 'stock'], ['POST' => 0], null, false, true, null]],
        91 => [
            [['_route' => 'update_book', '_controller' => 'App\\Controller\\BookController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_book', '_controller' => 'App\\Controller\\BookController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
