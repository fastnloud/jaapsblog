<?php

namespace Application\Factory\Navigation;

use Application\Navigation\Navigation;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class NavigationFactory
 * @package Application\Factory\Navigation
 */
class NavigationFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Zend\Navigation\Navigation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new Navigation();
        $navigation->setPageService($serviceLocator->get('Page\Service\PageService'));
        $navigation->setBlogService($serviceLocator->get('Blog\Service\BlogService'));
        $navigation->setSiteService($serviceLocator->get('Site\Service\SiteService'));

        return $navigation->createService($serviceLocator);
    }

}