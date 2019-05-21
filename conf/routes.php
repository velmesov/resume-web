<?php
return [
    'routes' => [
        /* Ajax pages */
        [
            'pattern'    => SITE . '(TEST_PAGE|TEST_PAGE/[a-z]{1,})(/|)',
            'controller' => 'Cp',
            'method'     => 'main',
        ],
        /* Static pages */
        [
            'pattern'    => SITE,
            'controller' => 'Home',
            'method'     => 'main',
        ],
        /* API */
        [
            'pattern'    => SITE . '(?<api>api)/(?<controller>users)/all(/|)',
            'controller' => 'Users',
            'method'     => 'getAll',
        ],
        [
            'pattern'    => SITE . '(?<api>api)/(?<controller>users)/(?<id>([1-9]{1}|[1-9]{1}[0-9]{1,}))(/|)',
            'controller' => 'Users',
            'method'     => 'get',
        ]
    ]
];
