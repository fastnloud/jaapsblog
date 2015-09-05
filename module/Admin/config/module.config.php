<?php

return array(
    'admin' => array(
        'tables' => array(
            'site' => array(
                'service' => 'Site\Service\SiteService',
                'entity'  => 'Site\Entity\Site',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'banner' => array(
                'service' => 'Banner\Service\BannerService',
                'entity'  => 'Banner\Entity\Banner',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'footer' => array(
                'service' => 'Footer\Service\FooterService',
                'entity'  => 'Footer\Entity\Footer',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'page' => array(
                'service' => 'Page\Service\PageService',
                'entity'  => 'Page\Entity\Page',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'blog' => array(
                'service' => 'Blog\Service\BlogService',
                'entity'  => 'Blog\Entity\Blog',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),
            'reply' => array(
                'service' => 'Reply\Service\ReplyService',
                'entity'  => 'Reply\Entity\Reply',
                'actions' => array(
                    'read', 'create', 'update', 'destroy'
                )
            ),

            // root tables
            'route' => array(
                'service' => 'Route\Service\RouteService',
                'entity'  => 'Route\Entity\Route',
                'actions' => array(
                    'read'
                )
            ),
            'status' => array(
                'service' => 'Status\Service\StatusService',
                'entity'  => 'Status\Entity\Status',
                'actions' => array(
                    'read'
                )
            ),
            'category' => array(
                'service' => 'Category\Service\CategoryService',
                'entity'  => 'Category\Entity\Category',
                'actions' => array(
                    'read'
                )
            )
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Admin\Controller\AdminController' => 'Admin\Factory\Controller\AdminControllerFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\AdminController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'table' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => ':table[/:action]',
                            'constraints' => array(
                                'table'  => '[a-z][a-z_]+',
                                'action' => '(read|create|update|destroy)'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\AdminController',
                                'action'     => 'read'
                            ),
                        ),
                    ),
                )
            ),
        ),
    ),
);