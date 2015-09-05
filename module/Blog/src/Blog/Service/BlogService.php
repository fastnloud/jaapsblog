<?php

namespace Blog\Service;

use Application\Service\AbstractEntityService;

/**
 * Class BlogService
 * @package Blog\Service
 */
class BlogService extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntities();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function fetchEntity($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

    /**
     * @return mixed
     */
    public function fetchBlogItems()
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchBlogItems();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function fetchBlogItemBySlug($slug)
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchBlogItemBySlug($slug);
    }

}