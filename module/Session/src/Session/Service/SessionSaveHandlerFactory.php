<?php

namespace Session\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SessionSaveHandlerFactory
 * @package Session\Service
 */
class SessionSaveHandlerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SessionSaveHandler
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $saveHandler = new SessionSaveHandler();
        $saveHandler->setConfig($config['session']['save_handler']);
        $saveHandler->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $saveHandler;
    }

}