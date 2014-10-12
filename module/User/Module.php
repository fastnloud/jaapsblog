<?php

namespace User;

use Zend\Mvc\MvcEvent;

class Module
{

    /**
     * Trigger user event and check for existing users.
     * None found? Add default.
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $application->getEventManager()->attach($e::EVENT_DISPATCH, array($this, 'userEvent'), 900);
    }

    /**
     * Check for existing users.
     *
     * @param MvcEvent $e
     */
    public function userEvent(MvcEvent $e)
    {
        $userService = $e->getApplication()->getServiceManager()->get('UserService');

        if (!$userService->hasUsers()) {
            $userService->addDefaultUser();
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
                'UserService' => 'User\Service\UserFactory'
            )
        );
    }

}