<?php
return [
    'main' => [
        'debug'           => true,
        'path_log'        => '/var/logs',
        'default_lang'    => 'ru',
        'min_php_version' => '7.2.0',
        'protocol'        => 'http://',
        'cache'           => false,
    ],
    'session' => [
        'name'            => 'cms',
        'strict_mode'     => 1,
        'maxlifetime'     => 86400,
        'cookie_path'     => '/',
        'cookie_httponly' => 1,
        'save_path'       => '/var/sessions'
    ]
];
