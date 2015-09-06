<?php

namespace Application\Factory\ViewHelper;

use Application\View\Helper\SocialNetworksHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SocialNetworksHelperFactory
 * @package Application\Factory\ViewHelper
 */
class SocialNetworksHelperFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SocialNetworksHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewHelper = new SocialNetworksHelper();
        $viewHelper->setSiteService($serviceLocator->getServiceLocator()->get('Site\Service\SiteService'));

        return $viewHelper;
    }

}