<?php

return [
    'model' => \Kurious7\SimplePages\Models\SimplePage::class,
    'table' => 'pages',
    'route' => [
        'path' => '/p/{slug}',
        'register' => true,
    ],
    'view' => 'simple-pages::index',
];
