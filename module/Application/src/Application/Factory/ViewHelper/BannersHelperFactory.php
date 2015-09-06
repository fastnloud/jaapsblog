<?php

namespace Application\Factory\ViewHelper;

use Application\View\Helper\BannersHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class BannersHelperFactory
 * @package Application\Factory\ViewHelper
 */
class BannersHelperFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return BannersHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewHelper = new BannersHelper();
        $viewHelper->setSiteService($serviceLocator->getServiceLocator()->get('Site\Service\SiteService'));

        return $viewHelper;
    }

}