<?php

namespace Status\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class StatusFactory
 * @package Status\Service
 */
class StatusFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Status
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Status($serviceLocator);

        return $service;
    }

}