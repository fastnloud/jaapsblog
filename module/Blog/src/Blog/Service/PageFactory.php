<?php

namespace Blog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $page = new Page();
        $page->setRequest($serviceLocator->get('Request'));
        $page->setNavigation($serviceLocator->get('Navigation'));
        $page->setPageTable($serviceLocator->get('PageTable'));

        return $page;
    }

}