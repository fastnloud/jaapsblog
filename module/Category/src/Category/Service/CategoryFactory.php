<?php

namespace Category\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CategoryFactory
 * @package Category\Service
 */
class CategoryFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Category
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Category($serviceLocator);

        return $service;
    }

}