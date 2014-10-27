<?php

namespace Page\Entity;

use Application\Repository\AbstractEntityRepository;
use Doctrine\ORM\Query;

class PageRepository extends AbstractEntityRepository
{

    /**
     * @param bool $fetchAll
     * @return array
     */
    public function getPages($fetchAll = false)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('p', 's')
           ->from('Page\Entity\Page', 'p')
           ->join('p.status', 's');

        if (true !== $fetchAll) {
            $qb->where('p.status_id = :statusId')
               ->setParameter(':statusId', 1);
        }

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

}