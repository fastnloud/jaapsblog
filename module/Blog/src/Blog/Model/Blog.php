<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Blog implements InputFilterAwareInterface
{

    protected $id;
    protected $title;
    protected $subtitle;
    protected $lead;
    protected $content;
    protected $author;
    protected $date;
    protected $category;
    protected $status;
    protected $meta_title;
    protected $meta_description;
    protected $meta_keywords;
    protected $comments;
    
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
        $this->status                = (isset($data['status'])) ? $data['status'] : 'offline';
        $this->meta_title            = (isset($data['meta_title'])) ? $data['meta_title'] : null;
        $this->meta_description      = (isset($data['meta_description'])) ? $data['meta_description'] : null;
        $this->meta_keywords         = (isset($data['meta_keywords'])) ? $data['meta_keywords'] : null;
        $this->comments              = (isset($data['comments'])) ? $data['comments'] : null;
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

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $comments
     */
    public function setComments($comments)
    {
        $this->comments = (int) $comments;
    }

    /**
     * @return int
     */
    public function getComments()
    {
        return (int) $this->comments;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param string $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @param string $meta_keywords
     */
    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @param string $meta_title
     */
    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

}
