<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'AuthService' => 'Auth\Service\AuthFactory'
        )
    ),
    'controllers' => array(
        'factories' => array(
            'Auth\Controller\Auth' => 'Auth\Controller\AuthControllerFactory'
        )
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager'      => 'Doctrine\ORM\EntityManager',
                'identity_class'      => 'User\Entity\User',
                'identity_property'   => 'username',
                'credential_property' => 'password',
                'credential_callable' => array(new \Auth\Validator\Callback\Bcrypt(), 'validate')
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/auth/user[/:action]',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'authUser'
                    ),
                ),
            ),
        ),
    ),
);