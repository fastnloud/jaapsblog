<?php

namespace Page\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;
use Site\Entity\Site;

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
     * @param Site $site
     * @return mixed
     */
    public function fetchPages(Site $site)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status', 'site')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.site', 'site')
           ->andWhere('site = :site')
           ->andWhere('page.status = :status')
           ->setParameter(':site', $site)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

    /**
     * @param $slug
     * @param Site $site
     * @return mixed
     */
    public function fetchPageBySlug($slug, Site $site)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status', 'site')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.site', 'site')
           ->where('page.slug = :slug')
           ->andWhere('site = :site')
           ->andWhere('page.status = :status')
           ->setParameter(':slug', $slug)
           ->setParameter(':site', $site)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param $route
     * @param Site $site
     * @return mixed
     */
    public function fetchPageByRoute($route, Site $site)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('page', 'status', 'route', 'site')
           ->from('Page\Entity\Page', 'page')
           ->join('page.status', 'status')
           ->join('page.route', 'route')
           ->join('page.site', 'site')
           ->where('route.label = :route')
           ->andWhere('site = :site')
           ->andWhere('page.status = :status')
           ->setParameter(':route', $route)
           ->setParameter(':site', $site)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}