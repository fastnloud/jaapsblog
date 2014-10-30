<?php

namespace Blog\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

class BlogRepository extends AbstractEntityRepository
{

    /**
     * @param bool $fetchAll
     * @return array
     */
    public function getBlogItems($fetchAll = false)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('b', 's', 'c')
           ->from('Blog\Entity\Blog', 'b')
           ->join('b.status', 's')
           ->join('b.category', 'c');

        if (true !== $fetchAll) {
            $qb->where('p.status_id = :statusId')
               ->setParameter(':statusId', 1);
        }

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBlogItem($id)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('b', 's', 'c')
           ->from('Blog\Entity\Blog', 'b')
           ->join('b.status', 's')
           ->join('b.category', 'c')
           ->where('b.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}