<?php

namespace Auth\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new AuthController();
        $controller->setAuthService($serviceLocator->getServiceLocator()->get('AuthService'));
        $controller->setUserService($serviceLocator->getServiceLocator()->get('UserService'));
        $controller->setSessionManager($serviceLocator->getServiceLocator()->get('SessionManager'));
        $controller->setXCrfTokenValidator($serviceLocator->getServiceLocator()->get('ValidatorManager')->get('XCrfTokenValidator'));

        return $controller;
    }

}