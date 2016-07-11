<?php

return [
    'asset_manager' => [
        'resolver_configs' => [
            'aliases' => [
                'modules/open-graph/' => __DIR__ . '/../public/',
            ],
            'collections' => [
                'modules/rcm-admin/admin.js' => [
                    'modules/open-graph/properties.js'
                ],
            ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'controllers' => [
        'factories' => [
            'WShafer\Controller\AdminController'
                => \WShafer\OpenGraph\Controller\AdminControllerFactory::class,
        ],
    ],
    
    'router' => [
        'routes' => [
            'WShafer\OpenGraph\Admin\Save' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route' => '/open-graph/save/site/:siteId/page/:pageId',
                    'defaults' => [
                        'controller' => 'WShafer\Controller\AdminController',
                        'action' => 'save',
                    ],
                ],
            ],
        ],
    ],
    
    'navigation' => [
        'RcmAdminMenu' => [
            'Page' => [
                'pages' => [
                    'Edit' => [
                        'pages' => [
                            'OpenGraph' => [
                                'label' => 'Open Graph Properties',
                                'class' => 'RcmAdminMenu RcmBlankDialog',
                                'title' => 'Open Graph Properties',
                                'uri' => '/modules/open-graph/properties.html',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'doctrine' => [
        'driver' => [
            'WShafer\OpenGraph' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'WShafer\OpenGraph' => 'WShafer\OpenGraph'
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'metadata_cache' => 'doctrine_cache',
                'query_cache' => 'doctrine_cache',
                'result_cache' => 'doctrine_cache',
            ]
        ],
    ],

    'view_helpers' => [
        'factories' => [
            'openGraph' => \WShafer\OpenGraph\View\Helper\OpenGraphFactory::class
        ]
    ],

    'openGraph' => [
        'defaults' => [

            'facebook' => [
                'appId' => '1234',
            ],

            'general' => [
                'ogType' => 'website',
            ],

            'website' => [
                'title' => 'No Title',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Blank_License_Plate_Shape.jpg',
                'description' => '',
                'siteName' => '',
            ],

            'article' => [
                'title' => 'No Title',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Blank_License_Plate_Shape.jpg',
                'description' => '',
                'siteName' => '',
                'author' => '',
                'section' => ''
            ],
        ],
    ],
];
