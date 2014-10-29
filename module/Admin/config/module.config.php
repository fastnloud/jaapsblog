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
                        'controller' => 'Admin\Controller\Page'
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
            )
        ),
    ),
);