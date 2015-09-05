<?php

namespace User\Factory\Service;

use User\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserServiceFactory
 * @package User\Factory\Service
 */
class UserServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new UserService($serviceLocator);
        $service->setConfig($serviceLocator->get('Config'));
        $service->init();

        return $service;
    }

}