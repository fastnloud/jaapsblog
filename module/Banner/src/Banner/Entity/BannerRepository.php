<?php

namespace Banner\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class BannerRepository
 * @package Banner\Entity
 */
class BannerRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('banner', 'site', 'status')
           ->from('Banner\Entity\Banner', 'banner')
           ->join('banner.status', 'status')
           ->join('banner.site', 'site');

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

        $qb->select('banner', 'site', 'status')
           ->from('Banner\Entity\Banner', 'banner')
           ->join('banner.status', 'status')
           ->join('banner.site', 'site')
           ->where('banner.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}