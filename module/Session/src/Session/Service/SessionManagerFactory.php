<?php

namespace Session\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;

/**
 * Class SessionManagerFactory
 * @package Session\Service
 */
class SessionManagerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SessionManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']['config']);

        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->setSessionConfig($config['session']);
        $sessionManager->setRequest($serviceLocator->get('Request'));
        $sessionManager->setSaveHandler($serviceLocator->get('SessionSaveHandler'));
        $sessionManager->init();

        return $sessionManager;
    }

}