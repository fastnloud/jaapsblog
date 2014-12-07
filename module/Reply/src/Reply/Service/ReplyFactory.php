<?php

namespace Reply\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReplyFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $category = new Reply();
        $category->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $category;
    }

}