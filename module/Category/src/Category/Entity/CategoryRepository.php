<?php

namespace Category\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

class CategoryRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function getCategory()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('c')
           ->from('Category\Entity\Category', 'c');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

}