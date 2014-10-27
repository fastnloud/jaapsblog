<?php

namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

abstract class AbstractService
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var int
     */
    protected $queryHydrator = Query::HYDRATE_OBJECT;

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
     * @param int $queryHydrator
     * @return $this
     */
    public function setQueryHydrator($queryHydrator)
    {
        $this->queryHydrator = (int) $queryHydrator;

        return $this;
    }

    /**
     * @return int
     */
    protected function getQueryHydrator()
    {
        return (int) $this->queryHydrator;
    }

}