<?php

namespace Page\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class PageFactory
 * @package Page\Service
 */
class PageFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Page
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Page($serviceLocator);

        return $service;
    }

}