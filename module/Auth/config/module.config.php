<?php

return array (
    'secure_areas' => array(
        'Admin\Controller\Page',
        'Admin\Controller\Blog'/* => array(
            'add',
            'edit',
            'delete'
        ),
        'Blog\Controller\Page' => array(
            'edit'
        )*/
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/login',
                    'constraints' => array(
                        'action' => 'login'
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'login'
                    ),
                ),
            ),
            'auth_logout' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/logout',
                    'constraints' => array(
                        'action' => 'logout'
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'logout'
                    ),
                ),
            ),
        ), 
    ),
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Auth' => 'Auth\Controller\AuthController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),
        
);