<?php

namespace Application\Factory\ViewHelper;

use Application\View\Helper\FooterHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FooterHelperFactory
 * @package Application\Factory\ViewHelper
 */
class FooterHelperFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FooterHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewHelper = new FooterHelper();
        $viewHelper->setSiteService($serviceLocator->getServiceLocator()->get('Site\Service\SiteService'));

        return $viewHelper;
    }

}