<?php

namespace Blog\Service;

use Application\Service\AbstractEntityService;
use Site\Entity\Site;

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
     * @param Site $site
     * @return mixed
     */
    public function fetchBlogItems(Site $site)
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchBlogItems($site);
    }

    /**
     * @param $slug
     * @param Site $site
     * @return mixed
     */
    public function fetchBlogItemBySlug($slug, Site $site)
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchBlogItemBySlug($slug, $site);
    }

}