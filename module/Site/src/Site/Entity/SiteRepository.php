<?php

namespace Site\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

class SiteRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function getSites()
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
    public function getSite($id)
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

}