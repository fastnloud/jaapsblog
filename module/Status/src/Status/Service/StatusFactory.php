<?php

namespace Status\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatusFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $status = new Status();
        $status->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $status;
    }

}