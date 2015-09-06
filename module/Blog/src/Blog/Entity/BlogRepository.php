<?php

namespace Blog\Entity;

use Application\Entity\AbstractEntityRepository;
use Doctrine\ORM\Query;
use Site\Entity\Site;

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

        $qb->select('blog', 'status', 'site', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.site', 'site')
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

        $qb->select('blog', 'status', 'site', 'reply')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.site', 'site')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.id = :id')
           ->setParameter(':id', $id);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

    /**
     * @param Site $site
     * @return array
     */
    public function fetchBlogItems(Site $site)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('blog', 'status', 'reply', 'site')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.site', 'site')
           ->leftJoin('blog.reply', 'reply')
           ->where('site = :site')
           ->andWhere('blog.status = :status')
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
    public function fetchBlogItemBySlug($slug, Site $site)
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder();

        $qb->select('blog', 'status', 'reply', 'site')
           ->from('Blog\Entity\Blog', 'blog')
           ->join('blog.status', 'status')
           ->join('blog.site', 'site')
           ->leftJoin('blog.reply', 'reply')
           ->where('blog.slug = :slug')
           ->andWhere('site = :site')
           ->andWhere('blog.status = :status')
           ->setParameter(':slug', $slug)
           ->setParameter(':site', $site)
           ->setParameter(':status', 1);

        return $qb->getQuery()
                  ->getSingleResult($this->getQueryHydrator());
    }

}