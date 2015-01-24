<?php

namespace User\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class UserFactory
 * @package User\Service
 */
class UserFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new User($serviceLocator);
        $service->setConfig($serviceLocator->get('Config'));
        $service->init();

        return $service;
    }

}