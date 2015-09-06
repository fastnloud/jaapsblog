<?php

namespace Application\Factory\ViewHelper;

use Application\View\Helper\SiteTitleHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SiteTitleHelperFactory
 * @package Application\Factory\ViewHelper
 */
class SiteTitleHelperFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SiteTitleHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewHelper = new SiteTitleHelper();
        $viewHelper->setSiteService($serviceLocator->getServiceLocator()->get('Site\Service\SiteService'));

        return $viewHelper;
    }

}