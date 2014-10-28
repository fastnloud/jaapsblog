<?php

return array(
    'router' => array(
        'routes' => array(
            'admin_page' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/page',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Page',
                        'action'     => 'index'
                    ),
                ),
            ),
            'admin_status' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/admin/status',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Status',
                        'action'     => 'index'
                    ),
                ),
            )
        ),
    ),
);