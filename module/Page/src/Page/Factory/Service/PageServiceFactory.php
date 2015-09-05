<?php

namespace Page\Factory\Service;

use Page\Service\PageService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PageServiceFactory
 * @package Page\Factory\Service
 */
class PageServiceFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return PageService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new PageService($serviceLocator);

        return $service;
    }

}