<?php

namespace Footer\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FooterFactory
 * @package Footer\Service
 */
class FooterFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Footer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Footer($serviceLocator);

        return $service;
    }

}