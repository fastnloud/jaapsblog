<?php

namespace Application\Factory\Validator;

use Application\Validator\XCrfToken;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\Exception;

/**
 * Class XCrfTokenValidatorFactory
 * @package Application\Factory\Validator
 */
class XCrfTokenValidatorFactory implements AbstractFactoryInterface
{

    /**
     * Determine if we can create a service with name.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (false !== stristr($requestedName, 'XCrfTokenValidator')) {
            $class = 'Application\Validator\XCrfToken';

            if (class_exists($class)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create service with name.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $class = 'Application\Validator\XCrfToken';

        $validator = new $class();
        if ($validator instanceof XCrfToken) {
            $validator->setRequest($serviceLocator->getServiceLocator()->get('Request'));
        }

        return $validator;
    }

}