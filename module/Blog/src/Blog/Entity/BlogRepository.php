<?php

namespace Blog\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;

/**
 * Class BlogRepository
 * @package Blog\Entity
 */
class BlogRepository extends AbstractEntityRepository
{

    /**
     * @return array
     */
    public function fetchEntities()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('blog', 'status', 'category', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.category', 'category')
           ->leftJoin('blog.reply', 'reply');

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

        $qb->select('blog', 'status', 'category', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.category', 'category')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}