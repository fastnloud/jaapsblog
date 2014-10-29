<?php

namespace Status\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

class StatusRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function getStatus()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('s')
           ->from('Status\Entity\Status', 's');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

}