<?php

return [
    'table' => 'pages',
    'route' => [
        'path' => '/p/{slug}',
        'register' => false,
    ],
    'view' => 'simple-pages::default',
];
