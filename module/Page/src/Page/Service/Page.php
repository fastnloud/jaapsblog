<?php

namespace Page\Service;

use Application\Entity\AbstractEntityService;

/**
 * Class Page
 * @package Page\Service
 */
class Page extends AbstractEntityService
{

    /**
     * @return mixed
     */
    public function fetchEntities()
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
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
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchEntity($id);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function fetchPageBySlug($slug)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchPageBySlug($slug);
    }

}