<?php

namespace Page\Entity;

use Application\Entity\AbstractEntityRepository;
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

    /**
     * @param $id
     * @return mixed
     */
    public function getPage($id)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('p', 's')
           ->from('Page\Entity\Page', 'p')
           ->join('p.status', 's')
           ->where('p.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getPageBySlug($slug)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('p')
           ->from('Page\Entity\Page', 'p')
           ->where('p.slug = :slug')
           ->setParameter(':slug', $slug);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}