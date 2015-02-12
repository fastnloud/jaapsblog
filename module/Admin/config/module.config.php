<?php

return array(
    'admin' => array(
        'tables' => array(
            'site' => array(
                'service' => 'SiteService',
                'entity'  => 'Site\Entity\Site',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'banner' => array(
                'service' => 'BannerService',
                'entity'  => 'Banner\Entity\Banner',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'footer' => array(
                'service' => 'FooterService',
                'entity'  => 'Footer\Entity\Footer',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'page' => array(
                'service' => 'PageService',
                'entity'  => 'Page\Entity\Page',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'blog' => array(
                'service' => 'BlogService',
                'entity'  => 'Blog\Entity\Blog',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'reply' => array(
                'service' => 'ReplyService',
                'entity'  => 'Reply\Entity\Reply',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),

            // root tables
            'route' => array(
                'service' => 'RouteService',
                'entity'  => 'Route\Entity\Route',
                'actions' => array(
                    'read'
                )
            ),
            'status' => array(
                'service' => 'StatusService',
                'entity'  => 'Status\Entity\Status',
                'actions' => array(
                    'read'
                )
            ),
            'category' => array(
                'service' => 'CategoryService',
                'entity'  => 'Category\Entity\Category',
                'actions' => array(
                    'read'
                )
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminControllerFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/:table[/:action]',
                    'constraints' => array(
                        'table'  => '[a-z][a-z_]+',
                        'action' => '(read|create|update|destroy)'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action'     => 'read'
                    ),
                ),
            ),
        ),
    ),
);