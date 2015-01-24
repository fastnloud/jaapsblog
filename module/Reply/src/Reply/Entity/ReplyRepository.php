<?php

namespace Reply\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class ReplyRepository
 * @package Reply\Entity
 */
class ReplyRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('reply')
           ->from('Reply\Entity\Reply', 'reply');

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

        $qb->select('reply', 'blog')
           ->from('Reply\Entity\Reply', 'reply')
           ->join('reply.blog', 'blog')
           ->where('reply.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}