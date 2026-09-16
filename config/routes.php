<?php

$hive = Base::instance();

$static_routes = [
    '/' => '/home',
    '/about' => '/home'
];

foreach ($static_routes as $url => $view) {
    $hive->route(
        "GET $url",
        fn() => view("pages/web$view")
    );
}
