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

        $qb->select('blog', 'status', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
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

        $qb->select('blog', 'status', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @return array
     */
    public function fetchBlogItems()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('blog', 'status', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.status = :status')
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getResult($this->getQueryHydrator());
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function fetchBlogItemBySlug($slug)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('blog', 'status', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.status = :status AND blog.slug = :slug')
           ->setParameter(':status', 1)
           ->setParameter(':slug', $slug);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}