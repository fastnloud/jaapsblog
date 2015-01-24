<?php

namespace Application\Validator\Entity;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\Exception;

/**
 * Class EntityValidatorFactory
 * @package Application\Validator\Entity
 */
class EntityValidatorFactory implements AbstractFactoryInterface, MutableCreationOptionsInterface
{

    /**
     * @var array
     */
    protected $options;

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
        if(false !== stristr($requestedName, 'EntityValidator')) {
            $class = 'Application\Validator\Entity\\' . substr($requestedName, 15);

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
        $class = 'Application\Validator\Entity\\' . substr($requestedName, 15);

        $validator = new $class();
        if ($validator instanceof AbstractEntityValidator) {
            $validator->setEntityManager($serviceLocator->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            $validator->setRepository($this->getOption('repository'));
            $validator->setField($this->getOption('field'));
            $validator->setExclude($this->getOption('exclude'));
        }

        return $validator;
    }

    /**
     * Set creation options.
     *
     * @param  array $options
     * @return void
     */
    public function setCreationOptions(array $options)
    {
        if (isset($options['repository'])) {
            $this->setOption('repository', $options['repository']);
        }

        if (isset($options['field'])) {
            $this->setOption('field', $options['field']);
        }

        if (isset($options['exclude'])) {
            $this->setOption('exclude', $options['exclude']);
        }
    }

    /**
     * Set option key/value pair.
     *
     * @param $key
     * @param $value
     */
    protected function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Get option by key.
     *
     * @param $key
     * @return null|string
     */
    protected function getOption($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        return null;
    }

}