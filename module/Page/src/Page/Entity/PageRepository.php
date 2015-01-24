<?php

namespace Page\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class PageRepository
 * @package Page\Entity
 */
class PageRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchEntity($id)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->where('page.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function fetchPageBySlug($slug)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page')
           ->from('Page\Entity\Page', 'page')
           ->where('page.slug = :slug')
           ->setParameter(':slug', $slug);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}