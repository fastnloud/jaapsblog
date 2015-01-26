<?php

namespace Footer\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class FooterRepository
 * @package Footer\Entity
 */
class FooterRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('footer', 'site', 'status')
           ->from('Footer\Entity\Footer', 'footer')
           ->join('footer.status', 'status')
           ->join('footer.site', 'site');

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

        $qb->select('footer', 'site', 'status')
           ->from('Footer\Entity\Footer', 'footer')
           ->join('footer.status', 'status')
           ->join('footer.site', 'site')
           ->where('footer.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}