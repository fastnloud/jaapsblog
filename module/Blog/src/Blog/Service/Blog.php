<?php

namespace Blog\Service;

use Application\Entity\AbstractEntityService;

class Blog extends AbstractEntityService
{

    public function getBlogItems()
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getBlogItems();
    }

    public function getAllBlogItems()
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getBlogItems(true);
    }

    public function getBlogItem($id)
    {
        return $this->getEntityManager()
                    ->getRepository('Blog\Entity\Blog')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->getBlogItem($id);
    }

}