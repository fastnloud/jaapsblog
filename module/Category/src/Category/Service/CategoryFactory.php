<?php

namespace Category\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoryFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $category = new Category();
        $category->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $category;
    }

}