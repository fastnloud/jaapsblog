<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Blog implements InputFilterAwareInterface
{
    public $id;
    public $title;
    public $subtitle;
    public $lead;
    public $content;
    public $author;
    public $date;
    public $category;
    public $rating;
    public $status;
    public $amazon_item_id;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id                    = (isset($data['id'])) ? $data['id'] : null;
        $this->title                 = (isset($data['title'])) ? $data['title'] : null;
        $this->subtitle              = (isset($data['subtitle'])) ? $data['subtitle'] : null;
        $this->lead                  = (isset($data['lead'])) ? $data['lead'] : null;
        $this->content               = (isset($data['content'])) ? $data['content'] : null;
        $this->author                = (isset($data['author'])) ? $data['author'] : null;
        $this->date                  = (isset($data['date'])) ? $data['date'] : null;
        $this->category              = (isset($data['category'])) ? $data['category'] : 'social';
        $this->rating                = (isset($data['rating'])) ? $data['rating'] : null;
        $this->status                = (isset($data['status'])) ? $data['status'] : 'offline';
        $this->amazon_item_id        = (isset($data['amazon_item_id'])) ? $data['amazon_item_id'] : null;
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
                'name'     => 'id',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
    
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
                'name'     => 'category',
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
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
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
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'lead',
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
