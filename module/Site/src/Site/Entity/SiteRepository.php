<?php

namespace Site\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class SiteRepository
 * @package Site\Entity
 */
class SiteRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('site', 'status')
           ->from('Site\Entity\Site', 'site')
           ->join('site.status', 'status');

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

        $qb->select('site', 'status')
           ->from('Site\Entity\Site', 'site')
           ->join('site.status', 'status')
           ->where('site.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param $domain
     * @return mixed
     */
    public function fetchSiteByDomain($domain)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('site', 'status', 'banner', 'footer')
           ->from('Site\Entity\Site', 'site')
           ->join('site.status', 'status')
           ->join('site.banner', 'banner')
           ->join('site.footer', 'footer')
           ->where('site.domain = :domain')
           ->andWhere('site.status = :status')
           ->setParameter(':domain', $domain)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}