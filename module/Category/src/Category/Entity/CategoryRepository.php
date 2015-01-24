<?php

namespace Category\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CategoryRepository
 * @package Category\Entity
 */
class CategoryRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('category')
           ->from('Category\Entity\Category', 'category');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

}