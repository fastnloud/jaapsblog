<?php

namespace User\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $user = new User();
        $user->setConfig($serviceLocator->get('Config'));
        $user->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));
        $user->init();

        return $user;
    }

}