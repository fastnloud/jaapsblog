<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Reply implements InputFilterAwareInterface
{

    public $id;
    public $id_blog;
    public $name;
    public $comment;
    public $is_admin;
    public $timestamp;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id        = (isset($data['id'])) ? $data['id'] : null;
        $this->id_blog   = (isset($data['id_blog'])) ? $data['id_blog'] : null;
        $this->name      = (isset($data['name'])) ? $data['name'] : null;
        $this->comment   = (isset($data['comment'])) ? $data['comment'] : null;
        $this->is_admin  = (isset($data['is_admin'])) ? $data['is_admin'] : null;
        $this->timestamp = (isset($data['timestamp'])) ? $data['timestamp'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'subject',
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 0,
                            'max' => 0
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'comment',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
