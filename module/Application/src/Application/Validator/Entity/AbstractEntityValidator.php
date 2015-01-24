<?php

namespace Application\Validator\Entity;

use Doctrine\ORM\EntityManager;
use Zend\Validator\AbstractValidator;

/**
 * Class AbstractEntityValidator
 * @package Application\Validator\Entity
 */
abstract class AbstractEntityValidator extends AbstractValidator
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $repository;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $exclude;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param string $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    protected function getField()
    {
        return $this->field;
    }

    /**
     * @param string $exclude
     */
    public function setExclude($exclude)
    {
        $this->exclude = $exclude;
    }

    /**
     * @return string
     */
    protected function getExclude()
    {
        return $this->exclude;
    }

}