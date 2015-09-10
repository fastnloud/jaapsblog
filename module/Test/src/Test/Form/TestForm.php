<?php

namespace Test\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TestForm
 * @package Test\Form
 */
class TestForm extends Form implements ServiceLocatorAwareInterface, InputFilterProviderInterface
{

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @return void
     */
    public function init()
    {
        $elements = array(
            array(
                'spec' => array(
                    'name' => 'test',
                    'options' => array(
                        'label' => 'test',
                    ),
                    'type'  => 'Text',
                )
            ),
            array(
                'spec' => array(
                    'name' => 'test2',
                    'options' => array(
                        'label' => 'test 2',
                    ),
                    'type'  => 'Text',
                )
            ),
            array(
                'spec' => array(
                    'name' => 'submit',
                    'type'  => 'Submit',
                    'attributes' => array(
                        'value' => 'Submit',
                    ),
                ),
            )
        );

        $this->getFormFactory()->configureForm($this, array(
            'elements' => $elements
        ));
    }


    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'test' => array(
                'required' => true
            ),
            'test2' => array(
                'required' => true
            )
        );
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}