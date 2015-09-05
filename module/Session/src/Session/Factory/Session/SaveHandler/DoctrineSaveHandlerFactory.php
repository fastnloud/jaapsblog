<?php

namespace Session\Factory\Session\SaveHandler;

use Session\Session\SaveHandler\DoctrineSaveHandler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DoctrineSaveHandlerFactory
 * @package Session\Factory\Session\SaveHandler
 */
class DoctrineSaveHandlerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return DoctrineSaveHandler
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $saveHandler = new DoctrineSaveHandler();
        $saveHandler->setConfig($config['session']['save_handler']);
        $saveHandler->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));

        return $saveHandler;
    }

}