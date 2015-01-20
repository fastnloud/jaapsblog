<?php

return array(
    'router' => array(
        'routes' => array(
            'admin_page' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/page[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Page',
                        'action'     => 'read'
                    ),
                ),
            ),
            'admin_blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/blog[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Blog',
                        'action'     => 'read'
                    ),
                ),
            ),
            'admin_site' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/site[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Site',
                        'action'     => 'read'
                    ),
                ),
            ),
            'admin_reply' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/reply[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Reply',
                        'action'     => 'read'
                    ),
                ),
            ),
            'admin_status' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/status',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Status',
                        'action'     => 'read'
                    ),
                ),
            ),
            'admin_category' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/category',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Category',
                        'action'     => 'read'
                    ),
                ),
            )
        ),
    ),
);