<?php

return [
    'table' => 'pages',
    'route' => [
        'path' => '/p/{slug}',
        'register' => true,
    ],
    'view' => 'simple-pages::index',
];
