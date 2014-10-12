<?php

namespace Auth;

use Auth\Controller\AuthController;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            /*'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),*/
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthService' => 'Auth\Service\AuthFactory'
            )
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Auth\Controller\Auth' => function($sm) {
                    $controller = new AuthController();
                    $controller->setAuthService($sm->getServiceLocator()->get('AuthService'));
                    $controller->setUserService($sm->getServiceLocator()->get('UserService'));

                    return $controller;
                }
            )
        );
    }

}