<?php

namespace Banner\Factory\Service;

use Banner\Service\BannerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BannerServiceFactory
 * @package Banner\Factory\Service
 */
class BannerServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BannerService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new BannerService($serviceLocator);

        return $service;
    }

}