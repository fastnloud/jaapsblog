<?php

namespace Page\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;
use Route\Entity\Route;

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

        $qb->select('page', 'status', 'route', 'site')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.route', 'route')
           ->join('page.site', 'site');

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

        $qb->select('page', 'status', 'route', 'site')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.route', 'route')
           ->join('page.site', 'site')
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

        $qb->select('page', 'status')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->where('page.slug = :slug AND status = :status')
           ->setParameter(':status', 1)
           ->setParameter(':slug', $slug);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param Route $route
     * @return mixed
     */
    public function fetchPageByRoute(Route $route)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status', 'route')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.route', 'route')
           ->where('route = :route')
           ->andWhere('page.status = :status')
           ->setParameter(':route', $route)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @return array
     */
    public function fetchPages()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'route')
           ->from('Page\Entity\Page', 'page')
           ->join('page.route', 'route')
           ->where('page.status = :status')
           ->setParameter(':status', 1)
           ->orderBy('page.priority', 'ASC');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

}