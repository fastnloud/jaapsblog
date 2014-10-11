<?php

return array(
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/auth/user',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'authUser'
                    ),
                ),
            )
        ),
    ),
);