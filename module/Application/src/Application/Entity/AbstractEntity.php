<?php

namespace Application\Entity;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

abstract class AbstractEntity implements InputFilterAwareInterface
{

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        return null;
    }

}