<?php

namespace Session;

use Zend\Mvc\MvcEvent;
use Zend\Http\Request;

/**
 * Class Module
 * @package Session
 */
class Module
{

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        if ($e->getRequest() instanceof Request) {
            $sessionManager = $e->getApplication()
                                ->getServiceManager()
                                ->get('SessionManager');

            $sessionManager->start();
        }
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
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

}
