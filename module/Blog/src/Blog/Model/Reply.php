<?php

namespace Blog\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Reply implements InputFilterAwareInterface
{

    protected $id;
    protected $id_blog;
    protected $name;
    protected $comment;
    protected $is_admin;
    protected $timestamp;

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

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param int $id_blog
     */
    public function setIdBlog($id_blog)
    {
        $this->id_blog = (int) $id_blog;
    }

    /**
     * @return int
     */
    public function getIdBlog()
    {
        return (int) $this->id_blog;
    }

    /**
     * @param bool $is_admin
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = (bool) $is_admin;
    }

    /**
     * @return bool
     */
    public function getIsAdmin()
    {
        return (bool) $this->is_admin;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

}
