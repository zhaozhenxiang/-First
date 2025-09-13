<?php

declare(strict_types=1);
return [
    'driver' => 'mysql',
    'resultType' => PDO::FETCH_ASSOC,
    'connection' => [
        'mysql' => [
            'host' => '127.0.0.1',
            'port' => '3306',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'test'
        ]
    ]
];