<?php

namespace Blog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $blog = new Blog();
        $blog->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $blog;
    }

}