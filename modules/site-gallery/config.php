<?php

return [
    '__name' => 'site-gallery',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/site-gallery.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-gallery' => ['install','remove'],
        'modules/site-gallery' => ['install','update','remove'],
        'theme/site/gallery' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'gallery' => NULL
            ],
            [
                'site' => NULL
            ],
            [
                'site-meta' => NULL
            ],
            [
                'lib-formatter' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-event' => NULL
            ],
            [
                'lib-cache-output' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteGallery\\Controller' => [
                'type' => 'file',
                'base' => ['app/site-gallery/controller','modules/site-gallery/controller']
            ],
            'SiteGallery\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-gallery/library'
            ],
            'SiteGallery\\Meta' => [
                'type' => 'file',
                'base' => 'modules/site-gallery/meta'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteGallerySingle' => [
                'path' => [
                    'value' => '/gallery/(:slug)',
                    'params' => [
                        'slug' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteGallery\\Controller\\Gallery::single'
            ],
            'siteGalleryFeed' => [
                'path' => [
                    'value' => '/gallery/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteGallery\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'gallery:created' => [
                'SiteGallery\\Library\\Event::clear' => TRUE
            ],
            'gallery:deleted' => [
                'SiteGallery\\Library\\Event::clear' => TRUE
            ],
            'gallery:updated' => [
                'SiteGallery\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'gallery' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteGallerySingle',
                        'params' => [
                            'slug' => '$slug'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteGallery\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SiteGallery\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];