<?php

namespace Session;

use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $sessionManager = $e->getApplication()
                            ->getServiceManager()
                            ->get('SessionManager');

        $sessionManager->start();

        $container = new Container('init');
        if (!isset($container->init)) {
            $sessionManager->regenerateId(true);
            $container->init = true;
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            /*'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),*/
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SessionManager'     => 'Session\Service\SessionManagerFactory',
                'SessionSaveHandler' => 'Session\Service\SessionSaveHandlerFactory'
            )
        );
    }

}
