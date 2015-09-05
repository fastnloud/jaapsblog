<?php

namespace Auth\Factory\Controller;

use Auth\Controller\AuthController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthControllerFactory
 * @package Auth\Factory\Controller
 */
class AuthControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller = new AuthController();
        $controller->setAuthService($serviceLocator->getServiceLocator()->get('Auth\Service\AuthService'));
        $controller->setUserService($serviceLocator->getServiceLocator()->get('User\Service\UserService'));
        $controller->setSessionManager($serviceLocator->getServiceLocator()->get('Session\Session\SessionManager'));
        $controller->setXCrfTokenValidator($serviceLocator->getServiceLocator()->get('ValidatorManager')->get('XCrfTokenValidator'));

        return $controller;
    }

}