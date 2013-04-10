<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Page implements InputFilterAwareInterface
{
    public $id;
    public $title;
    public $url_string;
    public $content;
    public $status;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id                    = (isset($data['id'])) ? $data['id'] : null;
        $this->title                 = (isset($data['title'])) ? $data['title'] : null;
        $this->url_string            = (isset($data['url_string'])) ? $data['url_string'] : null;
        $this->content               = (isset($data['content'])) ? $data['content'] : null;
        $this->status                = (isset($data['status'])) ? $data['status'] : 'offline';
        $this->meta_title            = (isset($data['meta_title'])) ? $data['meta_title'] : null;
        $this->meta_description      = (isset($data['meta_description'])) ? $data['meta_description'] : null;
        $this->meta_keywords         = (isset($data['meta_keywords'])) ? $data['meta_keywords'] : null;
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
                'name'     => 'title',
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
                'name'     => 'content',
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
