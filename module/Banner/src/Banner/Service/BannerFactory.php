<?php

namespace Banner\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BannerFactory
 * @package Banner\Service
 */
class BannerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Banner
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Banner($serviceLocator);

        return $service;
    }

}