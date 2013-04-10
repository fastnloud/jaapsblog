<?php

return array (
    'router' => array(
        'routes' => array(
            'admin_blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/blog[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin_page' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/page[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Page',
                        'action'     => 'index',
                    ),
                ),
            ),
        ), 
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Blog' => 'Admin\Controller\BlogController',
            'Admin\Controller\Page' => 'Admin\Controller\PageController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);