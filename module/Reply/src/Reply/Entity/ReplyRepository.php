<?php

namespace Reply\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

class ReplyRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function getReplies()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('r')
           ->from('Reply\Entity\Reply', 'r');

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

    /**
     * @param $id
     * @return array
     */
    public function getReply($id)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('r', 'b')
           ->from('Reply\Entity\Reply', 'r')
           ->join('r.blog', 'b')
           ->where('r.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}