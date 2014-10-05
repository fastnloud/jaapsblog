<?php

namespace Page\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $page = new Page();
        $page->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $page;
    }

}