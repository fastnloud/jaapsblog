<?php

namespace Page\Service;

use Application\Service\AbstractEntityService;
use Route\Entity\Route;

/**
 * Class PageService
 * @package Page\Service
 */
class PageService extends AbstractEntityService
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

    /**
     * @param Route $route
     * @return mixed
     */
    public function fetchPageByRoute(Route $route)
    {
        return $this->getEntityManager()
                    ->getRepository('Page\Entity\Page')
                    ->setQueryHydrator($this->getQueryHydrator())
                    ->fetchPageByRoute($route);
    }

}