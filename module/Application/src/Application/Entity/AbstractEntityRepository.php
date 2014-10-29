<?php

namespace Application\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

abstract class AbstractEntityRepository extends EntityRepository
{

    /**
     * @var int
     */
    protected $queryHydrator = Query::HYDRATE_OBJECT;

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