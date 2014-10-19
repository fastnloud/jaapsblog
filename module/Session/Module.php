<?php

namespace Session;

use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $sessionManager = $e->getApplication()
                            ->getServiceManager()
                            ->get('SessionManager');

        $sessionManager->start();
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
