<?php

namespace User\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $user = new User($serviceLocator);
        $user->setConfig($serviceLocator->get('Config'));
        $user->init();

        return $user;
    }

}