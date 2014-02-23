<?php

namespace Auth;

use Auth\Controller\AuthController;
use Zend\Authentication\AuthenticationService;

class Module
{   
    
    /**
     * Add authentication check on dispatch when application
     * is being bootstrapped.
     * A high priority is set for this task.
     */
    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $application->getEventManager()->attach('dispatch', array($this, 'checkAuth'), 100);
    }
    
    /**
     * Here we'll check wheither authentication is needed for 
     * the section we're currently in.
     * 
     * @param $e
     * @return boolean
     */
    public function checkAuth($e)
    {
        // Firstly we'll fetch the needed params.
        $matches         = $e->getRouteMatch();
        $controller      = $matches->getParam('controller');
        $action          = $matches->getParam('action');
        $config          = $this->getConfig();
        $authenticated   = false;
        
        // Here we'll preform authentication.
        $auth = new AuthenticationService();
        if ($auth->getIdentity()) {
            $authenticated = true;
        }
        
        // And here we'll check if we're in fact dealing with a secure area.
        // IMPORTANT: Add secure areas in config file!
        $secureAreas = $config['secure_areas'];

        // Check authentication for given controller/actions.
        if (in_array($controller, $secureAreas)) {
            // deny all action
            if(empty($secureAreas[$controller])) {
                if (true !== $authenticated) {
                    header('HTTP/1.1 403 Forbidden');
                    exit(); // just to be sure.
                }
            }
            // specified
            elseif (in_array($action, $secureAreas[$controller])) {
                if (true !== $authenticated) {
                    header('HTTP/1.1 403 Forbidden');
                    exit(); // just to be sure.
                }
            }
        }

        // Couldn't find a more easy way.
        // TODO: Find a better way.
        define('AUTHENTICATED', $authenticated);
        
        return true;
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Auth\Controller\Auth' => function($sm) {
                    $controller = new AuthController();
                    $controller->setConfig($sm->getServiceLocator()->get('Config'));

                    return $controller;
                },
            )
        );
    }

    public function getServiceConfig()
    {
        return array();
    }
}