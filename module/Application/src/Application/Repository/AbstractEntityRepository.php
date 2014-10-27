<?php

namespace Application\Repository;

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
     * @param $this
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